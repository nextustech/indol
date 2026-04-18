<?php

namespace App\Http\Controllers;

use App\Mail\ContactReceived;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:191',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        try {
            Mail::to(config('mail.admin_email', 'info@indolia.com'))->send(new ContactReceived($contact));
        } catch (\Exception $e) {
            // Log::error('Contact email failed: ' . $e->getMessage());
        }

        return redirect()->route('contact')
            ->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }

    public function adminIndex(Request $request)
    {
        $contacts = Contact::when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->search, fn ($q, $s) => $q->where(fn ($q) => $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")->orWhere('subject', 'like', "%{$s}%")))
            ->when($request->unread, fn ($q) => $q->where('is_read', false))
            ->latest()
            ->paginate(15);

        $unreadCount = Contact::unread()->count();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    public function show(Contact $contact)
    {
        if (! $contact->is_read) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    public function markRead(Contact $contact)
    {
        $contact->markAsRead();

        return back()->with('success', 'Message marked as read.');
    }

    public function markUnread(Contact $contact)
    {
        $contact->update(['is_read' => false, 'status' => Contact::STATUS_NEW]);

        return back()->with('success', 'Message marked as unread.');
    }
}
