<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $appointments = Appointment::with(['patient', 'doctor'])->latest()->paginate(10);
        } elseif (Auth::user()->role === 'doctor') {
            $appointments = Auth::user()->doctorAppointments()->with('patient')->latest()->paginate(10);
        } else {
            $appointments = Auth::user()->patientAppointments()->with('doctor')->latest()->paginate(10);
        }

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string'
        ]);

        $appointmentDateTime = Carbon::parse($validated['appointment_date']);
        $dayOfWeek = strtolower($appointmentDateTime->format('l'));
        $time = $appointmentDateTime->format('H:i:s');

        // Validasi jadwal dokter
        $doctorSchedule = DoctorSchedule::where('doctor_id', $validated['doctor_id'])
            ->where('day', $dayOfWeek)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->first();

        if (!$doctorSchedule) {
            return back()->withErrors(['appointment_date' => 'Jadwal tidak tersedia pada waktu yang dipilih']);
        }

        $appointment = Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'notes' => $validated['notes']
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Janji temu berhasil dibuat.');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled'
        ]);

        $appointment->update(['status' => $validated['status']]);

        if ($validated['status'] === 'confirmed') {
            // Kirim notifikasi ke pasien
            $this->notifyPatient($appointment);
        }

        return redirect()->back()
            ->with('success', 'Status janji temu berhasil diperbarui.');
    }

    private function notifyPatient(Appointment $appointment)
    {
        // Menggunakan struktur tabel yang sesuai
        $appointment->patient->notifications()->create([
            'user_id' => $appointment->patient_id,
            'type' => 'appointment_confirmation',
            'message' => "Dokter telah siap untuk konsultasi pada " . 
                        $appointment->appointment_date->format('d M Y H:i'),
            'is_read' => false
        ]);
    }

    public function doctorHistory()
    {
        $appointments = Auth::user()
            ->doctorAppointments()
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.history', compact('appointments'));
    }

    public function history()
    {
        $appointments = Auth::user()->patientAppointments()
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);  // Menggunakan paginate() alih-alih get()
            
        return view('appointments.history', compact('appointments'));
    }
}
