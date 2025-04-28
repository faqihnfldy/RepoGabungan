<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\HealthReminder;

class HealthReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reminder;
    public $patient_name;
    public $doctor_name;

    public function __construct(HealthReminder $reminder)
    {
        $this->reminder = $reminder;
        $this->patient_name = $reminder->patient->name;
        $this->doctor_name = auth()->user()->name;
    }

    public function build()
    {
        return $this->view('emails.health-reminder')
                    ->subject('Pengingat Kesehatan dari MedFast');
    }
}