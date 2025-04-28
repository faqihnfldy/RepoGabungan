<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HealthReminder;
use App\Mail\HealthReminderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HealthReminderController extends Controller
{
    // Menampilkan daftar reminder
    public function index()
    {
        $reminders = HealthReminder::with('patient')->latest()->get();
        return view('admin.health-reminder.index', compact('reminders'));
    }

    // Menampilkan form tambah
    public function create()
    {
        $patients = User::where('role', 'user')->get();
        return view('admin.health-reminder.create', compact('patients'));
    }

    // Menyimpan reminder baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reminder_type' => 'required|in:medication,checkup,sleep',
            'reminder_time' => 'required',
            'frequency' => 'required|in:daily,weekly,monthly'
        ]);

        // Simpan reminder
        $reminder = HealthReminder::create($validated);

        // Kirim email
        $patient = User::find($request->patient_id);
        Mail::to($patient->email)->send(new HealthReminderMail($reminder));

        return redirect()->route('admin.health-reminder.index')
            ->with('success', 'Reminder berhasil dibuat dan email telah dikirim');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $reminder = HealthReminder::findOrFail($id);
        $patients = User::where('role', 'user')->get();
        return view('admin.health-reminder.edit', compact('reminder', 'patients'));
    }

    // Method untuk update data
    public function update(Request $request, $id)
    {
        $reminder = HealthReminder::findOrFail($id);
        
        // Validasi input
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reminder_type' => 'required|in:medication,checkup,sleep',
            'reminder_time' => 'required',
            'frequency' => 'required|in:daily,weekly,monthly'
        ]);

        // Update reminder
        $reminder->update($validated);

        return redirect()->route('admin.health-reminder.index')
            ->with('success', 'Reminder berhasil diperbarui');
    }

    public function destroy($id)
    {
        $reminder = HealthReminder::findOrFail($id);
        $reminder->delete();

        return redirect()->route('admin.health-reminder.index')
            ->with('success', 'Health reminder berhasil dihapus');
    }
}