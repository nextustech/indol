<?php

namespace App\Http\Controllers;

use App\Mail\ContactReceived;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-trash-contact', ['only'=>['trash']]);
        $this->middleware('permission:restore-contact', ['only'=>['restore']]);
        $this->middleware('permission:force-delete-contact', ['only'=>['forceDelete']]);
    }
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
        $contact->deleteRecord();

        return redirect()->route('admin.IndexContact')
            ->with('success', 'Contact message deleted successfully.');
    }

    public function trash()
    {
        $contacts = Contact::onlyDeleted()->latest('deleted_at')->paginate(15);
        return view('admin.contacts.trash', compact('contacts'));
    }

    public function restore($id)
    {
        $contact = Contact::withDeleted()->findOrFail($id);
        $contact->restoreRecord();
        return redirect()->route('admin.contacts.trash')->with('success', 'Contact restored successfully.');
    }

    public function forceDelete($id)
    {
        $contact = Contact::withDeleted()->findOrFail($id);
        $contact->forceDeleteRecord();
        return redirect()->route('admin.contacts.trash')->with('success', 'Contact permanently deleted.');
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
