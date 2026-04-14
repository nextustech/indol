@extends('layouts.front')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    .confirmation-page {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #e8f4f8 0%, #f0f7ff 50%, #fafbff 100%);
        min-height: 100vh;
        padding: 3rem 1rem;
    }

    .confirmation-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 2rem;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.08),
            0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        max-width: 580px;
        margin: 0 auto;
        overflow: hidden;
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes checkmarkDraw {
        0% {
            stroke-dashoffset: 100;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }

    .success-icon-wrapper {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .success-icon-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.3; }
    }

    .success-circle {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
    }

    .success-checkmark {
        width: 50px;
        height: 50px;
    }

    .success-checkmark path {
        stroke: white;
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
        animation: checkmarkDraw 0.4s ease-out 0.5s forwards;
        stroke-dasharray: 100;
        stroke-dashoffset: 100;
    }

    .success-text {
        margin-top: 1.5rem;
        animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
    }

    .success-text h1 {
        color: white;
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .success-text p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        margin: 0.5rem 0 0;
    }

    .confirmation-body {
        padding: 2rem;
    }

    .appointment-id-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #f0f9ff;
        border: 1px solid #e0f2fe;
        color: #0369a1;
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .appointment-id-badge svg {
        width: 14px;
        height: 14px;
    }

    .details-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 1.25rem;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .detail-row {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.875rem 0;
        border-bottom: 1px solid #e2e8f0;
        transition: background 0.2s ease;
    }

    .detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-row:first-child {
        padding-top: 0;
    }

    .detail-icon {
        width: 44px;
        height: 44px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .detail-icon svg {
        width: 20px;
        height: 20px;
        color: #0ea5e9;
    }

    .detail-icon.patient svg { color: #8b5cf6; }
    .detail-icon.doctor svg { color: #10b981; }
    .detail-icon.date svg { color: #f59e0b; }
    .detail-icon.time svg { color: #ec4899; }
    .detail-icon.location svg { color: #6366f1; }

    .detail-content {
        flex: 1;
        min-width: 0;
    }

    .detail-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    .detail-value {
        font-size: 1rem;
        color: #0f172a;
        font-weight: 600;
        line-height: 1.4;
    }

    .highlight-date {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        margin-top: 0.5rem;
        display: inline-block;
    }

    .highlight-date .day {
        font-size: 1.5rem;
        font-weight: 700;
        color: #92400e;
        line-height: 1;
    }

    .highlight-date .month-year {
        font-size: 0.8rem;
        color: #b45309;
        font-weight: 500;
    }

    .qr-section {
        text-align: center;
        padding: 1.5rem;
        background: white;
        border-radius: 1rem;
        border: 2px dashed #e2e8f0;
        margin-top: 1.5rem;
    }

    .qr-code {
        width: 100px;
        height: 100px;
        background: #f8fafc;
        border-radius: 0.75rem;
        margin: 0 auto 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
    }

    .qr-code svg {
        width: 100%;
        height: 100%;
    }

    .qr-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }

    .qr-id {
        font-size: 0.7rem;
        color: #94a3b8;
        font-family: monospace;
        margin-top: 0.25rem;
    }

    .reminder-note {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 1px solid #a7f3d0;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-top: 1.5rem;
    }

    .reminder-icon {
        width: 36px;
        height: 36px;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .reminder-icon svg {
        width: 18px;
        height: 18px;
        color: white;
    }

    .reminder-text {
        flex: 1;
    }

    .reminder-text strong {
        display: block;
        font-size: 0.85rem;
        color: #065f46;
        margin-bottom: 0.15rem;
    }

    .reminder-text span {
        font-size: 0.75rem;
        color: #047857;
        line-height: 1.4;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
        border: none;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
    }

    .btn-primary-custom svg {
        width: 20px;
        height: 20px;
    }

    .btn-secondary-custom {
        background: white;
        color: #0f172a;
        border: 2px solid #e2e8f0;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-secondary-custom:hover {
        border-color: #0ea5e9;
        color: #0ea5e9;
        background: #f0f9ff;
    }

    .btn-secondary-custom svg {
        width: 20px;
        height: 20px;
    }

    .btn-outline-custom {
        background: transparent;
        color: #64748b;
        border: 2px solid #e2e8f0;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-outline-custom:hover {
        border-color: #94a3b8;
        color: #475569;
        background: #f8fafc;
    }

    .btn-outline-custom svg {
        width: 20px;
        height: 20px;
    }

    .button-row {
        display: flex;
        gap: 0.75rem;
    }

    .button-row .btn-secondary-custom,
    .button-row .btn-outline-custom {
        flex: 1;
    }

    .confirmation-footer {
        text-align: center;
        padding: 1.5rem 2rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .footer-links {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .footer-link {
        color: #64748b;
        font-size: 0.85rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        transition: color 0.2s ease;
    }

    .footer-link:hover {
        color: #0ea5e9;
    }

    .footer-link svg {
        width: 16px;
        height: 16px;
    }

    @media (max-width: 640px) {
        .confirmation-page {
            padding: 1rem 0.75rem;
        }

        .confirmation-card {
            border-radius: 1.5rem;
        }

        .success-icon-wrapper {
            padding: 2rem 1.5rem;
        }

        .success-text h1 {
            font-size: 1.5rem;
        }

        .confirmation-body {
            padding: 1.5rem 1rem;
        }

        .detail-row {
            padding: 0.75rem 0;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
        }

        .button-row {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<section class="confirmation-page">
    <div class="container">
        <div class="confirmation-card">
            <div class="success-icon-wrapper">
                <div class="success-circle">
                    <svg class="success-checkmark" viewBox="0 0 50 50">
                        <path d="M14 27 L22 35 L36 18"/>
                    </svg>
                </div>
                <div class="success-text">
                    <h1>Appointment Confirmed</h1>
                    <p>Your appointment has been successfully booked</p>
                </div>
            </div>

            <div class="confirmation-body">
                <div class="appointment-id-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>ID: {{ $appointmentId ?? 'APT-2024-78542' }}</span>
                </div>

                <div class="details-card">
                    <div class="detail-row">
                        <div class="detail-icon patient">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Patient Name</div>
                            <div class="detail-value">{{ $patientName ?? 'Sarah Mitchell' }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon doctor">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Appointment Type</div>
                            <div class="detail-value">{{ $doctorSpecialty ?? 'Chiropractic Specialist' }}</div>
                          <!--  <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">{{ $doctorName ?? 'Dr. James Wilson' }}</div> -->
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon date">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Date & Time</div>
                            <div class="detail-value">{{ $appointmentDate ?? 'Thursday, April 18, 2024' }}</div>
                            <div class="highlight-date">
                                <span class="day">{{ $appointmentDay ?? '18' }}</span>
                                <span class="month-year">{{ $appointmentMonthYear ?? 'APR 2024' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon time">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Time Slot</div>
                            <div class="detail-value">{{ $appointmentTime ?? '10:30 AM - 11:00 AM' }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon location">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Location</div>
                            <div class="detail-value">{{ $clinicName ?? 'Downtown Spine & Wellness Center' }}</div>
                            <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">{{ $clinicAddress ?? '245 Health Avenue, Suite 302' }}</div>
                        </div>
                    </div>
                </div>

                <div class="reminder-note">
                    <div class="reminder-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div class="reminder-text">
                        <strong>Note</strong>
                        <span> Please arrive 15 minutes early.</span>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn-primary-custom" onclick="addToCalendar()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Add to Calendar
                    </button>

                    <button type="button" class="btn-outline-custom" onclick="window.location.href='{{ route('bookAppointment') }}'">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Book Another Appointment
                    </button>
                </div>
            </div>

            <div class="confirmation-footer">
                <div class="footer-links">
                    <a href="#" class="footer-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Need Help?
                    </a>
                    <a href="#" class="footer-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Contact Us
                    </a>
                    <a href="#" class="footer-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email Confirmation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function downloadReceipt() {
        alert('Receipt download initiated for appointment {{ $appointmentId ?? "APT-2024-78542" }}');
    }

    function addToCalendar() {
        const event = {
            title: 'Appointment - {{ $doctorSpecialty ?? "Consultation" }}',
            start: '{{ $calendarStart ?? "2024-04-18T10:30:00" }}',
            end: '{{ $calendarEnd ?? "2024-04-18T11:00:00" }}',
            location: '{{ ($clinicName ?? "Downtown Spine & Wellness Center") . ", " . ($clinicAddress ?? "245 Health Avenue, Suite 302") }}',
            description: 'Appointment ID: {{ $appointmentId ?? "APT-2024-78542" }}\nPatient: {{ $patientName ?? "Sarah Mitchell" }}'
        };

        const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(event.title)}&dates=${formatGoogleDate(event.start)}/${formatGoogleDate(event.end)}&location=${encodeURIComponent(event.location)}&details=${encodeURIComponent(event.description)}`;

        window.open(googleCalendarUrl, '_blank');
    }

    function formatGoogleDate(dateStr) {
        const date = new Date(dateStr);
        return date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
    }
</script>
@endsection
