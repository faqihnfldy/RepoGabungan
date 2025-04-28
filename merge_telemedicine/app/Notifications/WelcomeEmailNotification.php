<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeEmailNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to MedFast!')
            ->line('Thank you for registering with MedFast.')
            ->line('Your account has been successfully created.')
            ->action('Login to MedFast', url('/login'))
            ->line('Thank you for using our application!');
    }
}
