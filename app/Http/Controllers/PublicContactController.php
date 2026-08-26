<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PubContactForm;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PublicContactController extends Controller
{
    public function show()
    {
        return view('modules.mod-ps.general.contact-us');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'email', 'max:255'],
            'Subject' => ['required', 'string', 'max:255'],
            'MessageBody' => ['required', 'string', 'max:2000'],
            'FormLocation' => ['nullable', 'string', 'in:Main Contact Page,FAQ Page'],
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ]);

        $contact = PubContactForm::create([
            'Name' => $request->input('Name'),
            'Email' => $request->input('Email'),
            'Subject' => $request->input('Subject'),
            'MessageBody' => $request->input('MessageBody'),
            'FormLocation' => $request->input('FormLocation', 'Main Contact Page'),
            'Status' => 'New',
        ]);

        try {
            Mail::raw(
                "New contact form submission:\n\nName: {$contact->Name}\nEmail: {$contact->Email}\nSubject: {$contact->Subject}\nMessage:\n{$contact->Message}\n\nLocation: {$contact->FormLocation}\nStatus: {$contact->Status}",
                function ($message) use ($contact) {
                    $message->to('website@justmy.health')
                        ->subject('JustMy.Health Contact Form: ' . $contact->Subject);
                }
            );
        } catch (\Throwable $e) {
            Log::error('Contact form email failed: ' . $e->getMessage());
        }

        return redirect()->route('contact-us')->with('status', 'Thank you — your message has been sent.');
    }
}