<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>New Portfolio Message</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Courier New', Courier, monospace;
    background: #0a0a14;
    color: #c8d8f0;
    padding: 32px 16px;
    line-height: 1.6;
  }
  .wrapper {
    max-width: 580px;
    margin: 0 auto;
  }
  .header {
    background: #05050f;
    border: 1px solid rgba(0,229,255,0.25);
    border-radius: 6px 6px 0 0;
    padding: 24px 32px;
    text-align: center;
    border-bottom: none;
  }
  .logo {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: #00e5ff;
    margin-bottom: 4px;
    text-shadow: 0 0 20px rgba(0,229,255,0.4);
  }
  .logo-sub {
    font-size: 11px;
    color: #4a6080;
    letter-spacing: 0.2em;
    text-transform: uppercase;
  }
  .body-card {
    background: #09091a;
    border: 1px solid rgba(0,229,255,0.15);
    border-top: none;
    border-bottom: none;
    padding: 32px;
  }
  .alert-banner {
    background: rgba(0,229,255,0.06);
    border: 1px solid rgba(0,229,255,0.2);
    border-radius: 4px;
    padding: 12px 16px;
    font-size: 12px;
    color: #00e5ff;
    letter-spacing: 0.06em;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .section-label {
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: #4a6080;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }
  .field-row {
    display: flex;
    gap: 0;
    margin-bottom: 12px;
  }
  .field-key {
    font-size: 11px;
    color: #ffb800;
    width: 80px;
    flex-shrink: 0;
    padding-top: 1px;
  }
  .field-val {
    font-size: 13px;
    color: #e8f4ff;
    flex: 1;
  }
  .message-block {
    background: #020209;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 4px;
    padding: 20px;
    margin-top: 20px;
  }
  .message-block .section-label {
    margin-bottom: 16px;
  }
  .message-text {
    font-size: 13px;
    color: #c8d8f0;
    line-height: 1.8;
    white-space: pre-wrap;
    word-break: break-word;
  }
  .reply-btn {
    display: inline-block;
    margin-top: 28px;
    background: #00e5ff;
    color: #05050f;
    font-family: 'Courier New', monospace;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    text-decoration: none;
    padding: 12px 28px;
    border-radius: 4px;
  }
  .footer {
    background: #05050f;
    border: 1px solid rgba(0,229,255,0.15);
    border-top: none;
    border-radius: 0 0 6px 6px;
    padding: 20px 32px;
    text-align: center;
  }
  .footer p {
    font-size: 10px;
    color: #4a6080;
    letter-spacing: 0.06em;
    margin-bottom: 4px;
  }
  .footer span { color: #00e5ff; }
  .meta-row {
    font-size: 10px;
    color: #4a6080;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(255,255,255,0.06);
    letter-spacing: 0.04em;
  }
</style>
</head>
<body>
<div class="wrapper">

  <!-- Header -->
  <div class="header">
    <div class="logo">ValOS</div>
    <div class="logo-sub">Portfolio Notification</div>
  </div>

  <!-- Body -->
  <div class="body-card">
    <div class="alert-banner">
      ⚡ &nbsp;New contact form submission received
    </div>

    <!-- Sender info -->
    <div class="section-label">// sender_info</div>

    <div class="field-row">
      <div class="field-key">name     </div>
      <div class="field-val">{{ $contact->name }}</div>
    </div>
    <div class="field-row">
      <div class="field-key">email    </div>
      <div class="field-val">{{ $contact->email }}</div>
    </div>
    <div class="field-row">
      <div class="field-key">subject  </div>
      <div class="field-val">{{ $contact->subject }}</div>
    </div>
    <div class="field-row">
      <div class="field-key">received </div>
      <div class="field-val">{{ $contact->created_at->format('D, M j Y \a\t g:i A') }}</div>
    </div>

    <!-- Message -->
    <div class="message-block">
      <div class="section-label">// message_body</div>
      <div class="message-text">{{ $contact->message }}</div>
    </div>

    <!-- Reply button -->
    <div style="text-align:center;">
      <a class="reply-btn" href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}">
        Reply to {{ $contact->name }} ↗
      </a>
    </div>

    <!-- Meta -->
    <div class="meta-row">
      <p>Submitted via ValOS Portfolio — <span>val@portfolio.dev</span></p>
      <p>Message ID: #{{ $contact->id }} &nbsp;·&nbsp; Reply-To is set to sender's email.</p>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>© {{ date('Y') }} <span>Val Krystoper Abilo</span> — QA Engineer II</p>
    <p>This is an automated notification from your portfolio contact form.</p>
  </div>

</div>
</body>
</html>
