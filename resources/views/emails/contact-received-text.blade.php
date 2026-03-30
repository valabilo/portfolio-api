⚡ ValOS Portfolio — New Contact Form Message
=============================================

You received a new message from your portfolio.

SENDER INFO
-----------
Name:     {{ $contact->name }}
Email:    {{ $contact->email }}
Subject:  {{ $contact->subject }}
Received: {{ $contact->created_at->format('D, M j Y \a\t g:i A') }}

MESSAGE
-------
{{ $contact->message }}

=============================================
Reply directly to this email — Reply-To is set to {{ $contact->email }}.
Message ID: #{{ $contact->id }}

© {{ date('Y') }} Val Krystoper Abilo — QA Engineer II
Automated notification from ValOS Portfolio contact form.
