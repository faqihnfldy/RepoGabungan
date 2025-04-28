<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller; // Tambahkan ini untuk mengimpor Controller
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        // Menampilkan jadwal dokter
        $schedules = DoctorSchedule::where('doctor_id', auth()->id())->get();
        return view('doctor.schedule', compact('schedules'));
    }

    public function create()
    {
        // Menampilkan form untuk menambah jadwal
        return view('doctor.schedule_create');
    }

    public function store(Request $request)
    {
        // Menyimpan jadwal dokter
        $request->validate([
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        DoctorSchedule::create([
            'doctor_id' => auth()->id(),
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('doctor.schedule')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        // Menghapus jadwal dokter
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('doctor.schedule')->with('success', 'Jadwal berhasil dihapus.');
    }
}
