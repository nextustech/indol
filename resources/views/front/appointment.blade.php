@extends('layouts.front')

@push('styles')
    <style>
        .booking-page {
            background: linear-gradient(180deg, #eef2ff 0%, #f8fbff 45%, #ffffff 100%);
            padding: 3rem 0 5rem;
        }

        .booking-shell {
            background: #fff;
            border-radius: 2.5rem;
            padding: 2.5rem;
            box-shadow: 0 35px 80px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }

        .booking-header {
            margin-bottom: 2rem;
        }

        .booking-badge {
            font-size: 0.75rem;
            letter-spacing: 0.4rem;
            text-transform: uppercase;
            color: #475569;
        }

        .booking-header h2 {
            font-size: 2.4rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .booking-header p {
            color: #475569;
            margin-bottom: 0.75rem;
        }

        .hero-badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .hero-pill {
            border-radius: 999px;
            padding: 0.35rem 1rem;
            font-size: 0.85rem;
            background: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.3);
            color: #075985;
        }

        .hero-pill--accent {
            background: rgba(37, 99, 235, 0.12);
            border-color: rgba(37, 99, 235, 0.3);
            color: #1d4ed8;
        }

        .booking-wrapper {
            border-radius: 1.5rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
            padding: 1.5rem;
            background: #f8fbff;
            box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.02);
        }

        .step-pill-nav {
            display: flex;
            gap: 0.6rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            margin-bottom: 1.25rem;
            -webkit-overflow-scrolling: touch;
        }

        .step-pill {
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            padding: 0.45rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            cursor: pointer;
            flex: 0 0 auto;
            transition: all 0.2s ease;
        }

        .step-pill.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.25);
        }

        .step-pill.completed {
            background: #dcfce7;
            border-color: #4ade80;
            color: #047857;
        }

        .step-pill__index {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid #cbd5f5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            background: #fff;
        }

        .step-pill.completed .step-pill__index {
            border-color: #4ade80;
            background: #22c55e;
            color: #fff;
        }

        .step-pill__title {
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .step-pill__check {
            font-size: 0.8rem;
        }

        .step-content {
            background: #fff;
            border-radius: 1.5rem;
            padding: 1.75rem;
            min-height: 320px;
            transition: opacity 0.25s ease;
        }

        .step-content.is-fading {
            opacity: 0.6;
        }

        .step-panel {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
        }

        .service-option {
            border-radius: 1.25rem;
            border: 1px solid #e5e7eb;
            padding: 1.25rem;
            background: #fff;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .service-option.selected {
            background: linear-gradient(145deg, rgba(37, 99, 235, 0.1), rgba(37, 99, 235, 0.02));
            border-color: #2563eb;
        }

        .service-option h3 {
            margin: 0;
            font-size: 1.1rem;
            color: #0f172a;
        }

        .service-option p {
            margin: 0.25rem 0 0;
            color: #475569;
            font-size: 0.9rem;
        }

        .branch-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .select-pill {
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            padding: 0.6rem 1rem;
            background: #f8fafc;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .select-pill.active {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.25);
        }

        .select-pill__icon {
            font-size: 0.9rem;
        }

        .calendar-wrapper {
            border-radius: 1.25rem;
            border: 1px solid #e5e7eb;
            padding: 1.25rem;
            background: #fff;
            box-shadow: 0 20px 35px rgba(15, 23, 42, 0.08);
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .calendar-month {
            font-weight: 600;
            font-size: 1.1rem;
            color: #0f172a;
        }

        .calendar-nav {
            border: 0;
            background: #e5e7eb;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }

        .calendar-nav:hover {
            background: #cbd5f5;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 0.35rem;
        }

        .calendar-day {
            border-radius: 0.85rem;
            border: 1px solid transparent;
            padding: 0.7rem;
            background: #f8fafc;
            text-align: center;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .calendar-day--label {
            background: transparent;
            border: 0;
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            cursor: default;
        }

        .calendar-day--disabled {
            color: #cbd5f5;
            cursor: not-allowed;
            background: #f0f4ff;
        }

        .calendar-day.is-selected {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.2);
        }

        .calendar-day--faded {
            opacity: 0.5;
        }

        .calendar-selected {
            margin: 0;
            font-size: 0.85rem;
            color: #475569;
        }

        .slot-summary-card {
            border-radius: 1.25rem;
            border: 1px solid #e5e7eb;
            padding: 1.25rem;
            background: #fff;
            box-shadow: 0 20px 35px rgba(15, 23, 42, 0.08);
        }

        .slot-summary-card.empty {
            border-style: dashed;
            color: #64748b;
        }

        .slot-summary-card h3 {
            margin: 0;
            font-size: 1.8rem;
            color: #0f172a;
        }

        .slot-summary-card p {
            margin: 0.35rem 0 0;
            color: #475569;
            font-size: 0.95rem;
        }

        .time-panel {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
        }

        .time-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-height: 340px;
            overflow-y: auto;
            padding-right: 0.25rem;
        }

        .time-entry {
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 0.85rem 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .time-entry.is-selected {
            background: linear-gradient(145deg, rgba(37, 99, 235, 0.12), rgba(37, 99, 235, 0.02));
            border-color: #2563eb;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
        }

        .time-entry__dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #22c55e;
            flex-shrink: 0;
        }

        .time-entry__meta {
            flex: 1;
            text-align: left;
        }

        .time-entry__meta strong {
            display: block;
            font-size: 1rem;
            color: #0f172a;
        }

        .time-entry__meta span {
            font-size: 0.85rem;
            color: #475569;
        }

        .time-entry__badge {
            border-radius: 999px;
            padding: 0.35rem 0.75rem;
            background: #e0f2fe;
            color: #0f172a;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .time-empty {
            font-size: 0.92rem;
            color: #64748b;
            text-align: center;
        }

        .step-actions {
            margin-top: 1rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .step-actions .btn {
            min-width: 120px;
        }

        .loading-skeleton {
            height: 80px;
            border-radius: 0.85rem;
            background: linear-gradient(90deg, #f4f4f5 0%, #e4e7eb 50%, #f4f4f5 100%);
            background-size: 200% 100%;
            animation: shimmer 1.4s ease infinite;
        }

        .review-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .review-item {
            border-radius: 0.9rem;
            border: 1px dashed #e0e7ff;
            padding: 0.85rem 1rem;
            background: #f8fafc;
            font-size: 0.95rem;
            color: #475569;
        }

        .review-item strong {
            display: block;
            color: #0f172a;
            font-size: 1rem;
        }

        @keyframes shimmer {
            to { background-position: -200% 0; }
        }

        @media (max-width: 768px) {
            .step-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .step-actions .btn {
                width: 100%;
            }

            .time-panel {
                grid-template-columns: 1fr;
            }

            .calendar-wrapper {
                padding: 1rem;
            }
        }
    </style>
@endpush

@section('content')
<section class="page-content-wrapper booking-page">
    <div class="container">
        <div class="booking-shell">
            <div class="booking-header">
                <div class="booking-badge">Book With Confidence</div>
                <h2>Schedule a care episode</h2>
                <p>Choose your service type, branch, and time slot—our calendar updates in real time so you only see slots that actually exist.</p>
                <div class="hero-badges">
                    <span class="hero-pill hero-pill--accent">Live branch calendars</span>
                    <span class="hero-pill">Auto-filtered slots</span>
                    <span class="hero-pill">Secure patient intake</span>
                </div>
            </div>
            <div class="booking-wrapper">
                <div class="step-pill-nav" id="step-pill-nav">
                    @php
                        $steps = [
                            ['title' => 'Service'],
                            ['title' => 'Branch'],
                            ['title' => 'Date'],
                            ['title' => 'Slots'],
                            ['title' => 'Time'],
                            ['title' => 'Details'],
                            ['title' => 'Review'],
                        ];
                    @endphp
                    @foreach($steps as $step)
                        <x-step-pill :step="$loop->iteration" :title="$step['title']" :status="$loop->iteration === 1 ? 'active' : 'upcoming'" />
                    @endforeach
                </div>
                <div class="step-content" id="step-content">
                    <div class="step-panel">
                        <p class="text-muted">Initializing booking...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<template id="branch-pill-template">
    {!! view('components.select-pill', ['id' => '__BRANCH__', 'label' => '__LABEL__', 'selected' => false])->render() !!}
</template>
@endsection

@push('scripts')
    <script>
        $(function () {
            const services = [
                { id: 'home_visit', label: 'Home Visit', hint: 'Doctor comes to your place.' },
                { id: 'video_consultation', label: 'Video Consultation', hint: 'Meet online with video.' },
                { id: 'at_clinic', label: 'Clinic Visit', hint: 'Visit our branch for a session.' },
            ];

            const state = {
                step: 1,
                service: null,
                branch: null,
                date: '',
                slot: null,
                patient: { name: '', email: '', phone: '', service: '' },
                availableSlots: [],
                branches: [],
            };

            const $stepNav = $('#step-pill-nav');
            const $stepContent = $('#step-content');
            const branchTemplate = $('#branch-pill-template').html();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function init() {
                bindEvents();
                loadStep(1);
            }

            function bindEvents() {
                $stepNav.on('click', '.step-pill', function () {
                    const target = Number($(this).data('step'));
                    if (target <= state.step) {
                        loadStep(target);
                    }
                });

                $stepContent.on('click', '.service-option', function () {
                    const selected = $(this).data('service');
                    state.service = selected;
                    state.branch = null;
                    state.availableSlots = [];
                    state.slot = null;
                    refreshServiceSelection();
                    refreshNextButton(1);
                });

                $stepContent.on('click', '.select-pill', function () {
                    const branchId = $(this).data('id');
                    state.branch = branchId;
                    state.availableSlots = [];
                    state.slot = null;
                    highlightBranchPills();
                    refreshNextButton(2);
                });

                $stepContent.on('change', '#booking-date', function () {
                    state.date = $(this).val();
                    state.availableSlots = [];
                    state.slot = null;
                    refreshNextButton(3);
                });

                $stepContent.on('click', '.slot-card', function () {
                    const slotId = $(this).data('slot');
                    state.slot = state.availableSlots.find(s => s.id === slotId);
                    refreshSlotSelection();
                    refreshNextButton(5);
                });

                $stepContent.on('input', '.patient-input', function () {
                    const field = $(this).data('field');
                    state.patient[field] = $(this).val();
                    refreshNextButton(6);
                });

                $stepContent.on('click', '.btn-next', function () {
                    const currentStep = Number($(this).data('step'));
                    if (checkStepReady(currentStep)) {
                        loadStep(currentStep + 1);
                    }
                });

                $stepContent.on('click', '.btn-back', function () {
                    const currentStep = Number($(this).data('step'));
                    if (currentStep > 1) {
                        loadStep(currentStep - 1);
                    }
                });

                $stepContent.on('submit', '#patient-form', function (e) {
                    e.preventDefault();
                    if (checkStepReady(6)) {
                        loadStep(7);
                    }
                });

                $stepContent.on('click', '#confirm-booking', function () {
                    submitBooking();
                });
            }

            function loadStep(step) {
                state.step = step;
                updateNav();
                const content = getStepContent(step);
                $stepContent.addClass('is-fading');
                setTimeout(() => {
                    $stepContent.html(content).removeClass('is-fading');
                    initializeStep(step);
                }, 180);
            }

            function updateNav() {
                $stepNav.find('.step-pill').each(function () {
                    const step = Number($(this).data('step'));
                    $(this).removeClass('active completed upcoming');
                    if (step === state.step) {
                        $(this).addClass('active');
                    } else if (step < state.step) {
                        $(this).addClass('completed');
                    } else {
                        $(this).addClass('upcoming');
                    }
                });
            }

            function getStepContent(step) {
                switch (step) {
                    case 1:
                        return renderServiceStep();
                    case 2:
                        return renderBranchStep();
                    case 3:
                        return renderDateStep();
                    case 4:
                        return renderSlotSummaryStep();
                    case 5:
                        return renderSlotSelectionStep();
                    case 6:
                        return renderPatientStep();
                    case 7:
                        return renderReviewStep();
                    default:
                        return '<div class="step-panel"><p>Unknown step.</p></div>';
                }
            }

            function initializeStep(step) {
                if (step === 2) {
                    renderBranchSkeleton();
                    fetchBranches();
                }
                if (step === 4) {
                    fetchSlots();
                }
                if (step === 5) {
                    renderSlotGrid();
                    refreshNextButton(5);
                }
                if (step === 6) {
                    refreshNextButton(6);
                }
            }

            function renderServiceStep() {
                const cards = services.map(service => {
                    const active = state.service === service.id ? 'selected' : '';
                    return `
                        <div class="service-option ${active}" data-service="${service.id}">
                            <h3>${service.label}</h3>
                            <p>${service.hint}</p>
                        </div>
                    `;
                }).join('');

                const nextDisabled = state.service ? '' : 'disabled';
                return `
                    <div class="step-panel">
                        <p class="text-muted">Choose whether you want a home visit, video consultation, or clinic appointment.</p>
                        <div class="service-grid">${cards}</div>
                        <div class="step-actions">
                            <button type="button" class="btn btn-outline-secondary btn-back" data-step="1" disabled>Back</button>
                            <button type="button" class="btn btn-primary btn-next" data-step="1" ${nextDisabled}>Next</button>
                        </div>
                    </div>
                `;
            }

            function renderBranchStep() {
                const nextDisabled = state.branch ? '' : 'disabled';
                return `
                    <div class="step-panel">
                        <p class="text-muted">Pick the branch or zone that suits the selected service.</p>
                        <div id="branch-pills" class="branch-pills"></div>
                        <input type="hidden" id="branch-id-input" value="${state.branch || ''}">
                        <div class="step-actions">
                            <button type="button" class="btn btn-outline-secondary btn-back" data-step="2">Back</button>
                            <button type="button" class="btn btn-primary btn-next" data-step="2" ${nextDisabled}>Next</button>
                        </div>
                    </div>
                `;
            }

            function renderDateStep() {
                const nextDisabled = state.date ? '' : 'disabled';
                const today = new Date().toISOString().split('T')[0];
                return `
                    <div class="step-panel">
                        <p class="text-muted">Choose the date that works best for you.</p>
                        <input type="date" id="booking-date" class="form-control" min="${today}" value="${state.date}">
                        <div class="step-actions">
                            <button type="button" class="btn btn-outline-secondary btn-back" data-step="3">Back</button>
                            <button type="button" class="btn btn-primary btn-next" data-step="3" ${nextDisabled}>Next</button>
                        </div>
                    </div>
                `;
            }

            function renderSlotSummaryStep() {
                return `
                    <div class="step-panel">
                        <div id="slot-summary">
                            <div class="loading-skeleton"></div>
                        </div>
                        <div class="step-actions">
                            <button type="button" class="btn btn-outline-secondary btn-back" data-step="4">Back</button>
                            <button type="button" class="btn btn-primary btn-next" data-step="4" disabled>Next</button>
                        </div>
                    </div>
                `;
            }

            function renderSlotSelectionStep() {
                return `
                    <div class="step-panel">
                        <p class="text-muted">Lock in a time slot from the available sessions.</p>
                        <div id="slot-grid" class="slot-grid"></div>
                        <div id="slot-empty" class="text-muted"></div>
                        <div class="step-actions">
                            <button type="button" class="btn btn-outline-secondary btn-back" data-step="5">Back</button>
                            <button type="button" class="btn btn-primary btn-next" data-step="5" disabled>Next</button>
                        </div>
                    </div>
                `;
            }

            function renderPatientStep() {
                return `
                    <div class="step-panel">
                        <p class="text-muted">Share your details so we can confirm the slot.</p>
                        <form id="patient-form">
                            <div class="mb-2">
                                <label class="form-label" for="patient-name">Full name</label>
                                <input type="text" class="form-control patient-input" id="patient-name" data-field="name" value="${state.patient.name}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="patient-phone">Phone</label>
                                <input type="text" class="form-control patient-input" id="patient-phone" data-field="phone" value="${state.patient.phone}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="patient-email">Email</label>
                                <input type="email" class="form-control patient-input" id="patient-email" data-field="email" value="${state.patient.email}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="patient-service">What do you need?</label>
                                <textarea class="form-control patient-input" id="patient-service" data-field="service" rows="2">${state.patient.service}</textarea>
                            </div>
                            <div class="step-actions">
                                <button type="button" class="btn btn-outline-secondary btn-back" data-step="6">Back</button>
                                <button type="submit" class="btn btn-primary btn-next" data-step="6" ${checkStepReady(6) ? '' : 'disabled'}>Next</button>
                            </div>
                        </form>
                    </div>
                `;
            }

            function renderReviewStep() {
                const serviceLabel = services.find(s => s.id === state.service)?.label || '—';
                const branchLabel = state.branch ? (state.branches.find(b => b.id === state.branch)?.branchName || state.branches.find(b => b.id === state.branch)?.name || '—') : '—';
                const slotLabel = state.slot ? `${state.slot.start_time} - ${state.slot.end_time}` : '—';
                return `
                    <div class="step-panel">
                        <p class="text-muted">Review your selections before confirming.</p>
                        <div class="review-list">
                            <div class="review-item">
                                <strong>Service</strong>
                                ${serviceLabel}
                            </div>
                            <div class="review-item">
                                <strong>Branch</strong>
                                ${branchLabel}
                            </div>
                            <div class="review-item">
                                <strong>Date</strong>
                                ${state.date || '—'}
                            </div>
                            <div class="review-item">
                                <strong>Time</strong>
                                ${slotLabel}
                            </div>
                            <div class="review-item">
                                <strong>Patient</strong>
                                ${state.patient.name || '—'}
                            </div>
                        </div>
                        <div class="step-actions">
                            <button type="button" class="btn btn-outline-secondary btn-back" data-step="7">Back</button>
                            <button type="button" id="confirm-booking" class="btn btn-primary btn-next" data-step="7">Confirm Appointment</button>
                        </div>
                    </div>
                `;
            }

            function renderBranchSkeleton() {
                $('#branch-pills').html('<div class="loading-skeleton" style="width:120px;"></div><div class="loading-skeleton" style="width:140px;"></div><div class="loading-skeleton" style="width:100px;"></div>');
            }

            function fetchBranches() {
                if (state.branches.length) {
                    renderBranchPills();
                    return;
                }

                $.get('/api/branches')
                    .done(data => {
                        state.branches = data;
                        renderBranchPills();
                    })
                    .fail(() => {
                        $('#branch-pills').html('<p class="text-danger">Unable to load branches.</p>');
                    });
            }

            function renderBranchPills() {
                const html = state.branches.map(branch => {
                    return branchTemplate
                        .replace(/__BRANCH__/g, branch.id)
                        .replace(/__LABEL__/g, branch.branchName || branch.name || 'Branch');
                }).join('');
                $('#branch-pills').html(html);
                highlightBranchPills();
            }

            function highlightBranchPills() {
                $('#branch-pills').find('.select-pill').removeClass('active');
                if (state.branch) {
                    $(`#branch-pills .select-pill[data-id="${state.branch}"]`).addClass('active');
                }
            }

            function fetchSlots() {
                if (!state.branch || !state.date || !state.service) {
                    $('#slot-summary').html('<p class="text-muted">Please complete service, branch, and date before checking availability.</p>');
                    return;
                }

                $('#slot-summary').html('<div class="loading-skeleton"></div>');
                $.get('/api/slots', {
                    branch_id: state.branch,
                    date: state.date,
                    type: state.service
                })
                    .done(data => {
                        state.availableSlots = data;
                        renderSlotSummary();
                        renderSlotGrid();
                    })
                    .fail(() => {
                        state.availableSlots = [];
                        $('#slot-summary').html('<p class="text-danger">Failed to load availability.</p>');
                        $('.btn-next[data-step="4"]').prop('disabled', true);
                    });
            }

            function renderSlotSummary() {
                const count = state.availableSlots.length;
                if (count) {
                    $('#slot-summary').html(`<p class="text-muted">We found <strong>${count}</strong> slot(s) for your selection.</p>`);
                    $('.btn-next[data-step="4"]').prop('disabled', false);
                } else {
                    $('#slot-summary').html('<p class="text-muted">No slots available for this selection. Try another date or branch.</p>');
                    $('.btn-next[data-step="4"]').prop('disabled', true);
                }
            }

            function renderSlotGrid() {
                const $grid = $('#slot-grid');
                if (!state.availableSlots.length) {
                    $grid.empty();
                    $('#slot-empty').html('<p class="text-muted">Please adjust your previous selections.</p>');
                    return;
                }
                const cards = state.availableSlots.map(slot => {
                    const selected = state.slot && state.slot.id === slot.id ? 'selected' : '';
                    return `
                        <div class="slot-card ${selected}" data-slot="${slot.id}">
                            <h4>${slot.start_time} - ${slot.end_time}</h4>
                            <span>${slot.remaining} spot(s) left</span>
                            <span>${slot.type ? slot.type.replace('_', ' ') : 'General'}</span>
                        </div>
                    `;
                }).join('');
                $grid.html(cards);
                $('#slot-empty').empty();
            }

            function refreshServiceSelection() {
                $stepContent.find('.service-option').each(function () {
                    const service = $(this).data('service');
                    $(this).toggleClass('selected', service === state.service);
                });
            }

            function refreshSlotSelection() {
                $('#slot-grid').find('.slot-card').removeClass('selected');
                if (state.slot) {
                    $(`#slot-grid .slot-card[data-slot="${state.slot.id}"]`).addClass('selected');
                }
            }

            function refreshNextButton(step) {
                const $next = $stepContent.find(`.btn-next[data-step="${step}"]`);
                if ($next.length) {
                    $next.prop('disabled', !checkStepReady(step));
                }
            }

            function checkStepReady(step) {
                switch (step) {
                    case 1:
                        return !!state.service;
                    case 2:
                        return !!state.branch;
                    case 3:
                        return !!state.date;
                    case 4:
                        return state.availableSlots.length > 0;
                    case 5:
                        return !!state.slot;
                    case 6:
                        return !!state.patient.name && !!state.patient.phone && !!state.patient.service;
                    case 7:
                        return true;
                    default:
                        return false;
                }
            }

            function submitBooking() {
                if (state.step !== 7 || !state.slot) {
                    return;
                }

                const payload = {
                    name: state.patient.name,
                    email: state.patient.email,
                    phone: state.patient.phone,
                    branch_id: state.branch,
                    date: state.date,
                    slot_id: state.slot.id,
                    type: state.service,
                    service: state.patient.service
                };

                $('#confirm-booking').prop('disabled', true).text('Booking...');
                $.post('/appointments', payload)
                    .done((response) => {
                        showAlert('Appointment booked successfully.', 'success');
                        $('#confirm-booking').text('Booked').addClass('btn-success');
                        setTimeout(() => {
                            window.location.href = '/appointment/confirmation/' + (response.id || '1');
                        }, 1000);
                    })
                    .fail(() => {
                        showAlert('Failed to book. Please try again.', 'danger');
                        $('#confirm-booking').text('Confirm Appointment').prop('disabled', false);
                    });
            }

            function showAlert(message, type) {
                const alertHtml = `<div class="alert alert-${type} mt-3" role="alert">${message}</div>`;
                $stepContent.find('.alert').remove();
                $stepContent.find('.step-panel').first().append(alertHtml);
            }

            init();
        });
    </script>
@endpush
