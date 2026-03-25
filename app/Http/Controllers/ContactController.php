<?php
namespace App\Http\Controllers;

use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends BaseController
{

    public function contact()
    {
        return view('frontend.contact.index');
    }

    public function send(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            abort(403, 'Spam detected.');
        }

        // Validation
        $validated = $request->validate([
            'name'    => 'required|string|max:120',
            'email'   => 'required|email|max:150',
            'number'  => 'nullable|string|max:30',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // Send email
        try {Mail::raw(
            "Name: {$validated['name']}\n" .
            "Email: {$validated['email']}\n" .
            "Phone: {$validated['number']}\n\n" .
            "Message:\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to('drlizrios@gmail.com')
                    ->to('wlsfernandes@gmail.com')
                    ->subject('New Contact Message from Amid Mission Website')
                    ->replyTo($validated['email']);
            }
        );

            SystemLogger::log(
                'Starting email contact form submission',
                'info',
                'contact.email.start',
                [
                    'email' => $validated['email'],
                    'name'  => $validated['name'],
                ]
            );} catch (Exception $e) {

            SystemLogger::log(
                'Error sending contact form email',
                'error',
                'contact.email.error',
                [
                    'email' => $validated['email'],
                    'name'  => $validated['name'],
                    'error' => $e->getMessage(),
                ]
            );
            return back()->with('error', 'There was an error sending your message. Please try again later.');
        }

        return back()->with('success', 'Message sent successfully.');
    }

}
