<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body>
    <h2>New Contact Message Received</h2>
    
    <table width="100%" cellpadding="5">
        <tr>
            <td width="100"><strong>Name:</strong></td>
            <td>{{ $contact->name }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
        </tr>
        <tr>
            <td><strong>Phone:</strong></td>
            <td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td>
        </tr>
        <tr>
            <td><strong>Subject:</strong></td>
            <td>{{ $contact->subject }}</td>
        </tr>
        <tr>
            <td valign="top"><strong>Message:</strong></td>
            <td>{{ $contact->message }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td>{{ $contact->created_at->format('d M Y, h:i A') }}</td>
        </tr>
    </table>
    
    <p>
        <a href="{{ route('admin.contacts.show', $contact->id) }}">View in Admin Panel</a>
    </p>
</body>
</html>