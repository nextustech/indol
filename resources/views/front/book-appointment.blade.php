@extends('layouts.front')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .page-wrapper-booking {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f0f7ff 0%, #fafbff 100%);
        min-height: 100vh;
    }

    .booking-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .booking-head { text-align: center; margin-bottom: 2rem; }
    .booking-head h1 { font-size: 1.75rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
    .booking-head p { color: #64748b; font-size: 0.95rem; }

    .booking-row {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 768px) {
        .booking-row { grid-template-columns: 1fr; }
        .booking-sidebar { order: -1; }
    }

    .booking-sidebar { position: sticky; top: 2rem; }

    .prog-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .prog-step {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        padding: 0.75rem 0;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .prog-step.disabled { opacity: 0.5; cursor: not-allowed; }

    .prog-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        flex-shrink: 0;
        background: #f1f5f9;
        color: #94a3b8;
        border: 2px solid #e2e8f0;
        transition: all 0.2s;
    }
    .prog-step.active .prog-dot {
        background: #2563eb;
        color: #fff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    }
    .prog-step.done .prog-dot {
        background: #10b981;
        color: #fff;
        border-color: #10b981;
    }

    .prog-lbl { font-size: 0.85rem; font-weight: 600; color: #94a3b8; }
    .prog-step.active .prog-lbl { color: #2563eb; }
    .prog-step.done .prog-lbl { color: #10b981; }
    .prog-val { font-size: 0.8rem; color: #64748b; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .step-box {
        background: #fff;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        animation: fadeUp 0.3s ease;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .step-h { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem; }
    .step-sub { font-size: 0.9rem; color: #64748b; margin-bottom: 1.5rem; }

    .branch-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1rem;
    }

    .branch-item {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
    }
    .branch-item:hover { border-color: #3b82f6; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .branch-item.sel { border-color: #2563eb; background: #eff6ff; }

    .branch-row { display: flex; gap: 1rem; align-items: flex-start; }
    .branch-img { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; background: #f1f5f9; }
    .branch-info h3 { font-size: 0.95rem; font-weight: 600; color: #0f172a; margin-bottom: 0.25rem; }
    .branch-tag { font-size: 0.8rem; color: #64748b; }
    .branch-foot { display: flex; gap: 1rem; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #f1f5f9; }
    .branch-meta { font-size: 0.8rem; color: #475569; display: flex; align-items: center; gap: 0.35rem; }

    .svc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
    }

    .svc-item {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
    }
    .svc-item:hover { border-color: #3b82f6; transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .svc-item.sel { border-color: #2563eb; background: #eff6ff; }

    .svc-ico {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.25rem;
        transition: all 0.2s;
    }
    .svc-item.sel .svc-ico { background: #2563eb; color: #fff; }
    .svc-item h3 { font-size: 0.95rem; font-weight: 600; color: #0f172a; margin-bottom: 0.25rem; }
    .svc-item p { font-size: 0.8rem; color: #64748b; }

    .cal-row {
        display: grid;
        grid-template-columns: 1fr 260px;
        gap: 1.5rem;
    }
    @media (max-width: 640px) { .cal-row { grid-template-columns: 1fr; } }

    .cal-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid #e2e8f0;
    }

    .cal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .cal-nav {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        color: #475569;
    }
    .cal-nav:hover { background: #2563eb; border-color: #2563eb; color: #fff; }

    .cal-mo { font-size: 1rem; font-weight: 600; color: #0f172a; }

    .cal-g {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
    }

    .cal-wd { text-align: center; font-size: 0.75rem; font-weight: 600; color: #94a3b8; padding: 0.5rem 0; }

    .cal-d {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
        color: #334155;
    }
    .cal-d:hover:not(.off):not(.empty) { background: #eff6ff; color: #2563eb; }
    .cal-d.sel { background: #2563eb; color: #fff; font-weight: 600; }
    .cal-d.today { border: 2px solid #3b82f6; }
    .cal-d.off, .cal-d.empty { color: #cbd5e1; cursor: not-allowed; }

    .ts-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid #e2e8f0;
    }

    .ts-head { font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 1rem; }

    .ts-g {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }
    @media (max-width: 480px) { .ts-g { grid-template-columns: repeat(2, 1fr); } }

    .ts-item {
        padding: 0.625rem;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #fff;
        cursor: pointer;
        transition: all 0.15s;
        color: #334155;
    }
    .ts-item:hover { border-color: #3b82f6; color: #2563eb; }
    .ts-item.sel { background: #2563eb; border-color: #2563eb; color: #fff; font-weight: 600; }
    .ts-item.off { background: #f1f5f9; color: #94a3b8; cursor: not-allowed; }

    .det-form { display: grid; gap: 1rem; }
    .fld { display: flex; flex-direction: column; gap: 0.375rem; }
    .lbl { font-size: 0.85rem; font-weight: 600; color: #334155; }
    .inp {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.2s;
        background: #fff;
        color: #0f172a;
    }
    .inp:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .inp::placeholder { color: #94a3b8; }
    textarea.inp { resize: vertical; min-height: 100px; }

    .rev-g { display: grid; gap: 0.75rem; }
    .rev-r {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }
    .rev-r.hl { background: #eff6ff; border-color: rgba(37, 99, 235, 0.2); }
    .rev-r.hl .rv { color: #2563eb; }
    .rl { font-size: 0.85rem; color: #64748b; }
    .rv { font-size: 0.95rem; font-weight: 600; color: #0f172a; }

    .sum-box {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    .sum-t { font-size: 0.85rem; opacity: 0.9; margin-bottom: 0.5rem; }
    .sum-dt { font-size: 1.25rem; font-weight: 700; }

    .step-act {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
    }
    .btn-pri { background: #2563eb; color: #fff; flex: 1; }
    .btn-pri:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .btn-pri:disabled { background: #cbd5e1; cursor: not-allowed; transform: none; }
    .btn-sec { background: #f1f5f9; color: #475569; }
    .btn-sec:hover { background: #e2e8f0; }
    .btn-grn { background: #10b981; color: #fff; }
    .btn-grn:hover { background: #059669; }

    .no-data { text-align: center; padding: 2rem; color: #64748b; }

    .ok-box { text-align: center; padding: 3rem 1rem; }
    .ok-ico {
        width: 80px;
        height: 80px;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        animation: popIn 0.4s ease;
    }
    @keyframes popIn { 0% { transform: scale(0); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    .ok-ico svg { width: 40px; height: 40px; color: #fff; }
    .ok-h { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
    .ok-m { color: #64748b; margin-bottom: 1.5rem; }

    .skeleton {
        height: 80px;
        border-radius: 12px;
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: shimmer 1.2s infinite;
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @media (max-width: 640px) {
        .booking-wrap { padding: 1rem 0.75rem; }
        .step-box { padding: 1.25rem; }
        .step-h { font-size: 1.1rem; }
        .branch-grid { grid-template-columns: 1fr; }
        .svc-grid { grid-template-columns: 1fr 1fr; }
        .step-act { flex-direction: column; }
        .btn { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper-booking">
    <div class="booking-wrap">
        <div class="booking-head">
            <h1>Book Your Appointment</h1>
            <p>Schedule a visit in just a few simple steps</p>
        </div>

        <div class="booking-row">
            <aside class="booking-sidebar">
                <div class="prog-card">
                    <div class="prog-step active" data-step="1">
                        <div class="prog-dot">1</div>
                        <div><div class="prog-lbl">Branch</div><div class="prog-val" id="pg-branch">Select a branch</div></div>
                    </div>
                    <div class="prog-step disabled" data-step="2">
                        <div class="prog-dot">2</div>
                        <div><div class="prog-lbl">Service</div><div class="prog-val" id="pg-svc">Choose service</div></div>
                    </div>
                    <div class="prog-step disabled" data-step="3">
                        <div class="prog-dot">3</div>
                        <div><div class="prog-lbl">Date & Time</div><div class="prog-val" id="pg-dt">Pick slot</div></div>
                    </div>
                    <div class="prog-step disabled" data-step="4">
                        <div class="prog-dot">4</div>
                        <div><div class="prog-lbl">Your Details</div><div class="prog-val" id="pg-info">Enter info</div></div>
                    </div>
                    <div class="prog-step disabled" data-step="5">
                        <div class="prog-dot">5</div>
                        <div><div class="prog-lbl">Review</div><div class="prog-val" id="pg-rev">Confirm</div></div>
                    </div>
                </div>
            </aside>

            <main id="step-content"></main>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    var S = {
        step: 1,
        branch: null,
        svc: null,
        date: null,
        slot: null,
        pat: { name: '', phone: '', email: '', topic: '' },
        branches: [],
        services: [],
        slots: []
    };

    var weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    var calDate = new Date();

    function init() {
        loadBranches();
        render();
    }

    function loadBranches() {
        axios.get('/api/branches').then(function(res) {
            S.branches = res.data;
            render();
        }).catch(function() {
            S.branches = [];
            render();
        });
    }

    function loadServices(branchId, callback) {
        console.log('Loading services for branch:', branchId);
        var container = document.getElementById('svc-container');
        if (container) container.innerHTML = '<div class="skeleton"></div><div class="skeleton"></div>';

        axios.get('/api/get-types', { params: { branch_id: branchId } })
            .then(function(res) {
                console.log('Services loaded:', res.data);
                S.services = res.data.data || [];
                console.log('S.services:', S.services);
                if (callback) callback();
                else render();
            })
            .catch(function(err) {
                console.error('Failed to load services:', err);
                S.services = [];
                if (callback) callback();
                else render();
            });
    }

    function loadSlots(callback) {
        var tsG = document.getElementById('ts-g');
        if (tsG) tsG.innerHTML = '<div class="no-data">Loading...</div>';

        axios.get('/api/slots', {
            params: {
                branch_id: S.branch,
                appointment_type_id: S.svc,
                date: S.date
            }
        }).then(function(res) {
            S.slots = res.data.data || [];
            if (callback) callback();
            else render();
        }).catch(function(err) {
            console.error('Failed to load slots:', err);
            S.slots = [];
            if (callback) callback();
            else render();
        });
    }

    function render() {
        updateProg();
        document.getElementById('step-content').innerHTML = getContent();
        if (S.step === 3) initCal();
    }

function updateProg() {
        var steps = document.querySelectorAll('.prog-step');
        steps.forEach(function(el) {
            var n = parseInt(el.dataset.step);
            el.classList.remove('active', 'done', 'disabled');
            var dot = el.querySelector('.prog-dot');
            if (n === S.step) el.classList.add('active');
            else if (n < S.step) { el.classList.add('done'); dot.innerHTML = '✓'; }
            else el.classList.add('disabled');
        });

        if (S.branch) {
            var b = S.branches.find(function(x) { return S.branch && parseInt(x.id) === parseInt(S.branch); });
            document.getElementById('pg-branch').textContent = b ? (b.branchName || b.name) : 'Selected';
}
        if (S.date) document.getElementById('pg-dt').textContent = fmtDate(S.date);
        if (S.pat.name) document.getElementById('pg-info').textContent = S.pat.name;
    }

    function getContent() {
        switch(S.step) {
            case 1: return renderBranch();
            case 2: return renderSvc();
            case 3: return renderCal();
            case 4: return renderDet();
            case 5: return renderRev();
            default: return '';
        }
    }

    function renderBranch() {
        if (!S.branches.length) return '<div class=\"step-box\"><div class=\"no-data\">Loading branches...</div></div>';
        var html = S.branches.map(function(b) {
            var sel = (S.branch && parseInt(S.branch) === parseInt(b.id)) ? 'sel' : '';
            return '<div class=\"branch-item ' + sel + '\" data-id=\"' + b.id + '\">' +
                '<div class=\"branch-row\">' +
                    '<div class=\"branch-info\"><h3>' + (b.branchName || b.name) + '</h3><div class=\"branch-tag\">📍 ' + (b.specialty || 'General Care') + '</div></div>' +
                '</div>' +
                '<div class=\"branch-foot\"><div class=\"branch-meta\"><span>📍</span> ' + (b.address || 'View on map') + '</div></div>' +
            '</div>';
        }).join('');
        return '<div class=\"step-box\">' +
            '<h2 class=\"step-h\">Select a Branch</h2><p class=\"step-sub\">Choose the location most convenient for you</p>' +
            '<div class=\"branch-grid\">' + html + '</div>' +
            '<div class=\"step-act\"><button class=\"btn btn-pri\" id=\"next-btn\"' + (S.branch ? '' : ' disabled') + '>Continue <span>→</span></button></div>' +
        '</div>';
    }

    function renderSvc() {
        if (!S.services.length) return '<div class=\"step-box\"><div class=\"no-data\">Loading services...</div></div>';
        var html = S.services.map(function(s) {
            var sel = (S.svc && parseInt(S.svc) === parseInt(s.id)) ? 'sel' : '';
            return '<div class=\"svc-item ' + sel + '\" data-id=\"' + s.id + '\">' +
                '<div class=\"svc-ico\">🩺</div><h3>' + s.name + '</h3><p>' + (s.description || 'Book appointment') + '</p>' +
            '</div>';
        }).join('');
        if (!html) html = '<div class=\"no-data\">Select a branch first to see services</div>';
        return '<div class=\"step-box\" id=\"svc-container\">' +
            '<h2 class=\"step-h\">Choose a Service</h2><p class=\"step-sub\">Select the type of appointment you need</p>' +
            '<div class=\"svc-grid\">' + html + '</div>' +
            '<div class=\"step-act\">' +
                '<button class=\"btn btn-sec\" id=\"back-btn\">← Back</button>' +
                '<button class=\"btn btn-pri\" id=\"next-btn\"' + (S.svc ? '' : ' disabled') + '>Continue <span>→</span></button>' +
            '</div>' +
        '</div>';
    }

    function renderCal() {
        var slotsHtml = S.slots.length ? S.slots.map(function(slot) {
            var off = slot.available <= 0 ? 'off' : '';
            var sel = (S.slot && S.slot.start_time_db === slot.start_time_db) ? 'sel' : '';
            return '<div class=\"ts-item ' + sel + ' ' + off + '\" data-start=\"' + slot.start_time_db + '\" data-end=\"' + slot.end_time_db + '\"' + (off ? ' disabled' : '') + '>' + slot.start_time + '</div>';
        }).join('') : '<div class=\"no-data\">Select a date to see times</div>';
        return '<div class=\"step-box\">' +
            '<h2 class=\"step-h\">Pick a Date & Time</h2><p class=\"step-sub\">Select your preferred appointment slot</p>' +
            '<div class=\"cal-row\">' +
                '<div class=\"cal-box\">' +
                    '<div class=\"cal-head\">' +
                        '<button class=\"cal-nav\" id=\"prev-mo\">←</button>' +
                        '<span class=\"cal-mo\" id=\"mo-lbl\"></span>' +
                        '<button class=\"cal-nav\" id=\"next-mo\">→</button>' +
                    '</div>' +
                    '<div class=\"cal-g\" id=\"cal-g\"></div>' +
                '</div>' +
                '<div class=\"ts-box\">' +
                    '<div class=\"ts-head\">Available Times</div>' +
                    '<div class=\"ts-g\" id=\"ts-g\">' + slotsHtml + '</div>' +
                '</div>' +
            '</div>' +
            '<div class=\"step-act\">' +
                '<button class=\"btn btn-sec\" id=\"back-btn\">← Back</button>' +
                '<button class=\"btn btn-pri\" id=\"next-btn\"' + (S.date && S.slot ? '' : ' disabled') + '>Continue <span>→</span></button>' +
            '</div>' +
        '</div>';
    }

    function renderSvc() {
        var html = S.services.map(function(s) {
            var sel = S.svc == s.id ? 'sel' : '';
            return '<div class="svc-item ' + sel + '" data-id="' + s.id + '">' +
                '<div class="svc-ico">&#128137;</div><h3>' + s.name + '</h3><p>' + (s.description || 'Book appointment') + '</p>' +
            '</div>';
        }).join('');
        if (!html) html = '<div class="no-data">Select a branch first to see services</div>';
        return '<div class="step-box" id="svc-container">' +
            '<h2 class="step-h">Choose a Service</h2><p class="step-sub">Select the type of appointment you need</p>' +
            '<div class="svc-grid">' + html + '</div>' +
            '<div class="step-act">' +
                '<button class="btn btn-sec" id="back-btn">&#8592; Back</button>' +
                '<button class="btn btn-pri" id="next-btn"' + (S.svc ? '' : ' disabled') + '>Continue <span>&#8594;</span></button>' +
            '</div>' +
        '</div>';
    }

    function renderCal() {
        var slotsHtml = S.slots.length ? S.slots.map(function(slot) {
            var off = slot.available <= 0 ? 'off' : '';
            var sel = S.slot && S.slot.start_time_db === slot.start_time_db ? 'sel' : '';
            return '<div class="ts-item ' + sel + ' ' + off + '" data-start="' + slot.start_time_db + '" data-end="' + slot.end_time_db + '"' + (off ? ' disabled' : '') + '>' + slot.start_time + '</div>';
        }).join('') : '<div class="no-data">Select a date to see times</div>';
        return '<div class="step-box">' +
            '<h2 class="step-h">Pick a Date & Time</h2><p class="step-sub">Select your preferred appointment slot</p>' +
            '<div class="cal-row">' +
                '<div class="cal-box">' +
                    '<div class="cal-head">' +
                        '<button class="cal-nav" id="prev-mo">&#8592;</button>' +
                        '<span class="cal-mo" id="mo-lbl"></span>' +
                        '<button class="cal-nav" id="next-mo">&#8594;</button>' +
                    '</div>' +
                    '<div class="cal-g" id="cal-g"></div>' +
                '</div>' +
                '<div class="ts-box">' +
                    '<div class="ts-head">Available Times</div>' +
                    '<div class="ts-g" id="ts-g">' + slotsHtml + '</div>' +
                '</div>' +
            '</div>' +
            '<div class="step-act">' +
                '<button class="btn btn-sec" id="back-btn">&#8592; Back</button>' +
                '<button class="btn btn-pri" id="next-btn"' + (S.date && S.slot ? '' : ' disabled') + '>Continue <span>&#8594;</span></button>' +
            '</div>' +
        '</div>';
    }

    function initCal() {
        var yr = calDate.getFullYear();
        var mo = calDate.getMonth();
        var firstDay = new Date(yr, mo, 1).getDay();
        var totalDays = new Date(yr, mo + 1, 0).getDate();
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        document.getElementById('mo-lbl').textContent = calDate.toLocaleString('default', { month: 'long', year: 'numeric' });

        var html = weekDays.map(function(d) { return '<div class="cal-wd">' + d + '</div>'; }).join('');
        for (var i = 0; i < firstDay; i++) html += '<div class="cal-d empty"></div>';

        for (var day = 1; day <= totalDays; day++) {
            var dt = new Date(yr, mo, day);
            var dtStr = fmtDateISO(dt);
            var todayStart = new Date();
            todayStart.setHours(0, 0, 0, 0);
            var isPast = dt < todayStart;
            var isToday = dt.toDateString() === todayStart.toDateString();
            var isSel = S.date === dtStr;
            var cls = 'cal-d';
            if (isPast) cls += ' off';
            if (isToday) cls += ' today';
            if (isSel) cls += ' sel';
            html += '<div class="' + cls + '" data-date="' + dtStr + '">' + day + '</div>';
        }
        document.getElementById('cal-g').innerHTML = html;
    }

    function renderDet() {
        return '<div class="step-box">' +
            '<h2 class="step-h">Your Details</h2><p class="step-sub">Enter your information to complete the booking</p>' +
            '<div class="det-form">' +
                '<div class="fld"><label class="lbl">Full Name *</label><input type="text" class="inp" id="pat-name" placeholder="Enter your full name" value="' + escHtml(S.pat.name) + '"></div>' +
                '<div class="fld"><label class="lbl">Phone Number *</label><input type="tel" class="inp" id="pat-phone" placeholder="Enter your phone number" value="' + escHtml(S.pat.phone) + '"></div>' +
                '<div class="fld"><label class="lbl">Email</label><input type="email" class="inp" id="pat-email" placeholder="Enter your email (optional)" value="' + escHtml(S.pat.email) + '"></div>' +
                '<div class="fld"><label class="lbl">Reason for Visit</label><textarea class="inp" id="pat-topic" placeholder="Briefly describe your symptoms">' + escHtml(S.pat.topic) + '</textarea></div>' +
            '</div>' +
            '<div class="step-act">' +
                '<button class="btn btn-sec" id="back-btn">&#8592; Back</button>' +
                '<button class="btn btn-pri" id="next-btn">Review Booking <span>&#8594;</span></button>' +
            '</div>' +
        '</div>';
    }

function renderRev() {
        var branch = S.branches.find(function(b) { return S.branch && parseInt(b.id) === parseInt(S.branch); });
        var svc = S.services.find(function(s) { return S.svc && parseInt(s.id) === parseInt(S.svc); });
        return '<div class=\"step-box\">' +
            '<h2 class=\"step-h\">Review Your Booking</h2><p class=\"step-sub\">Please confirm all details are correct</p>' +
            '<div class=\"rev-g\">' +
                '<div class=\"rev-r\"><span class=\"rl\">Branch</span><span class=\"rv\">' + (branch ? (branch.branchName || branch.name) : '-') + '</span></div>' +
                '<div class=\"rev-r\"><span class=\"rl\">Service</span><span class=\"rv\">' + (svc ? svc.name : '-') + '</span></div>' +
                '<div class=\"rev-r hl\"><span class=\"rl\">Date</span><span class=\"rv\">' + (S.date ? fmtDate(S.date) : '-') + '</span></div>' +
                '<div class=\"rev-r hl\"><span class=\"rl\">Time</span><span class=\"rv\">' + (S.slot ? S.slot.start_time : '-') + '</span></div>' +
                '<div class=\"rev-r\"><span class=\"rl\">Patient</span><span class=\"rv\">' + (S.pat.name || '-') + '</span></div>' +
                '<div class=\"rev-r\"><span class=\"rl\">Phone</span><span class=\"rv\">' + (S.pat.phone || '-') + '</span></div>' +
            '</div>' +
            '<div class=\"sum-box\">' +
                '<div class=\"sum-t\">Your Appointment</div>' +
                '<div class=\"sum-dt\">' + (S.date ? fmtDate(S.date) : '') + ' at ' + (S.slot ? S.slot.start_time : '') + '</div>' +
            '</div>' +
            '<div class=\"step-act\">' +
                '<button class=\"btn btn-sec\" id=\"back-btn\">← Back</button>' +
                '<button class=\"btn btn-grn\" id=\"confirm-btn\">Confirm Booking ✓</button>' +
            '</div>' +
        '</div>';
    }

    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    document.addEventListener('click', function(e) {
        var el = e.target;

        if (el.closest('.prog-step') && !el.closest('.prog-step').classList.contains('disabled')) {
            S.step = parseInt(el.closest('.prog-step').dataset.step);
            render();
        }

        var branchEl = el.closest('.branch-item');
        if (branchEl) {
            S.branch = parseInt(branchEl.dataset.id);
            S.svc = null;
            S.date = null;
            S.slot = null;
            S.services = [];

            loadServices(S.branch);
            updateProg();
            render(); // Re-render to show selection

            // Enable continue button
            var nextBtn = document.getElementById('next-btn');
            if (nextBtn) nextBtn.disabled = false;
        }

        var svcEl = el.closest('.svc-item');
        if (svcEl) {
            S.svc = parseInt(svcEl.dataset.id);
            updateProg();
            render(); // Re-render to show selection
            // Enable continue button
            var nextBtn = document.getElementById('next-btn');
            if (nextBtn) nextBtn.disabled = false;
        }

        if (el.classList.contains('cal-d') && !el.classList.contains('off') && !el.classList.contains('empty')) {
            console.log('Date selected:', el.dataset.date);
            S.date = el.dataset.date;
            S.slot = null;
            S.slots = [];
            loadSlots();
            updateProg();
            render(); // Force re-render to show selection
        }

        if (el.classList.contains('ts-item') && !el.classList.contains('off')) {
            S.slot = {
                start_time: el.textContent,
                start_time_db: el.dataset.start,
                end_time_db: el.dataset.end
            };
            render();
            // Enable continue button
            var nextBtn = document.getElementById('next-btn');
            if (nextBtn) nextBtn.disabled = false;
        }

        if (el.id === 'prev-mo') {
            calDate.setMonth(calDate.getMonth() - 1);
            initCal();
        }
        if (el.id === 'next-mo') {
            calDate.setMonth(calDate.getMonth() + 1);
            initCal();
        }

        if (el.id === 'back-btn') {
            S.step--;
            // If coming back to step 2, ensure services are loaded
            if (S.step === 2 && S.branch && !S.services.length) {
                loadServices(S.branch);
            }
            render();
        }

        if (el.id === 'next-btn' && !el.disabled) {
            // If going to step 2 (services), ensure services are loaded
            if (S.step === 1 && S.branch && !S.services.length) {
                loadServices(S.branch, function() {
                    S.step++;
                    render();
                });
            }
            // If going to step 4 (details), ensure slots are loaded
            else if (S.step === 3 && S.date && !S.slots.length) {
                loadSlots();
                S.step++;
                render();
            }
            else {
                S.step++;
                render();
            }
        }

        if (el.id === 'confirm-btn') {
            el.disabled = true;
            el.textContent = 'Booking...';

            var payload = {
                branch_id: S.branch,
                appointment_type_id: S.svc,
                appointment_date: S.date,
                start_time: S.slot ? S.slot.start_time_db : null,
                end_time: S.slot ? S.slot.end_time_db : null,
                patient_name: S.pat.name,
                phone: S.pat.phone,
                email: S.pat.email,
                consultation_topic: S.pat.topic
            };

            axios.post('/api/book', payload).then(function(res) {
                if (res.data && res.data.data && res.data.data.id) {
                    window.location.href = '/appointment/confirmation/' + res.data.data.id;
                } else {
                    window.location.href = '/appointment/confirmation/1';
                }
            }).catch(function(err) {
                var msg = (err.response && err.response.data && err.response.data.message) ? err.response.data.message : 'Booking failed. Please try again.';
                alert(msg);
                el.disabled = false;
                el.textContent = 'Confirm Booking';
            });
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.id === 'pat-name') S.pat.name = e.target.value;
        if (e.target.id === 'pat-phone') S.pat.phone = e.target.value;
        if (e.target.id === 'pat-email') S.pat.email = e.target.value;
        if (e.target.id === 'pat-topic') S.pat.topic = e.target.value;
        updateProg();
    });

    function fmtDate(d) {
        return new Date(d).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
    }



    function fmtDateISO(d) {
    var year = d.getFullYear();
    var month = String(d.getMonth() + 1).padStart(2, '0');
    var day = String(d.getDate()).padStart(2, '0');
    return year + '-' + month + '-' + day;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush
