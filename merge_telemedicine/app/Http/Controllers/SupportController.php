<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function showContactForm()
    {
        return view('support.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Here you can add logic to send email to support team
        // For now, we'll just redirect with success message

        return back()->with('success', 'Your message has been sent to our support team. We will contact you shortly.');
    }
}