<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Show contact form
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Store contact message
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Save to database
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ]);

            // Success message
            return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you soon.');

        } catch (\Exception $e) {
            // Error message
            return redirect()->back()->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }

    /**
     * Show all messages (Admin panel)
     */
    public function messages()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    /**
     * Delete message
     */
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            
            return redirect()->back()->with('success', 'Message deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting message.');
        }
    }
}