@extends('layouts.front')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>

/* Layout */
.booking-wrapper {
    display: flex;
    gap: 30px;
}

.left-panel {
    width: 70%;
    position: sticky;
    top: 100px;
}

.right-panel {
    width: 30%;
}

/* Cards (Branch & Service) */
.card-select {
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 15px;
    cursor: pointer;
    transition: 0.3s;
    margin-bottom: 10px;
}

.card-select:hover {
    border-color: #000;
    transform: translateY(-2px);
}

.card-select.active {
    background: #000;
    color: #fff;
}

/* Slots */
.slot {
    padding: 12px;
    border: 1px solid #eee;
    border-radius: 8px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.slot:hover {
    border-color: #000;
}

.slot.full {
    background: #f5f5f5;
    color: #aaa;
    cursor: not-allowed;
}

.slot.selected {
    background: #000;
    color: #fff;
}

/* Section spacing */
.section-box {
    margin-bottom: 25px;
}

/* Animation */
.fade-in {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}
.calendar-days,
.calendar-dates {
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
}

.calendar-days div {
    text-align: center;
    font-size: 12px;
    color: #888;
}

.calendar-dates div {
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    cursor: pointer;
    background: #f5f5f5;
    transition: 0.2s;
}

.calendar-dates div:hover {
    background: #ddd;
}

.calendar-dates .active {
    background: #000;
    color: #fff;
}

.calendar-dates .disabled {
    background: #eee;
    color: #bbb;
    cursor: not-allowed;
}
</style>
@endpush


@section('content')

<div class="container py-5">

    <h3 class="mb-4">Book Appointment</h3>

    <div class="booking-wrapper">

        <!-- LEFT PANEL -->
        <div class="left-panel">

            <!-- Branch -->
            <div class="section-box">
                <h5>Select Branch</h5>
                <div id="branchList"></div>
            </div>

            <!-- Service -->
            <div class="section-box">
                <h5>Select Service</h5>
                <div id="typeList"></div>
            </div>

            <!-- Calendar -->
            <div class="section-box">
                <h5>Select Date</h5>
                <div class="calendar-wrapper">

                    <!-- Header -->
                    <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                        <button id="prevMonth" class="btn btn-sm btn-light">←</button>
                        <h5 id="monthYear" class="mb-0"></h5>
                        <button id="nextMonth" class="btn btn-sm btn-light">→</button>
                    </div>

                    <!-- Days -->
                    <div class="calendar-days d-grid mb-2">
                        <div>SUN</div><div>MON</div><div>TUE</div><div>WED</div>
                        <div>THU</div><div>FRI</div><div>SAT</div>
                    </div>

                    <!-- Dates -->
                    <div id="calendarDates" class="calendar-dates d-grid"></div>

                </div>
            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">

            <h5>Available Slots</h5>
            <div id="slotsContainer"></div>

            <!-- Form -->
            <div id="bookingForm" class="mt-4 d-none">
                <h5>Patient Details</h5>

                <input type="text" id="patient_name" class="form-control mb-2" placeholder="Full Name">
                <input type="email" id="email" class="form-control mb-2" placeholder="Email">
                <input type="text" id="phone" class="form-control mb-2" placeholder="Phone">
                <textarea id="consultation_topic" class="form-control mb-2" placeholder="Problem"></textarea>

                <button id="bookBtn" class="btn btn-dark w-100">Confirm Booking</button>
            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
let currentDate = new Date();

function renderCalendar() {

    let year = currentDate.getFullYear();
    let month = currentDate.getMonth();

    let firstDay = new Date(year, month, 1).getDay();
    let lastDate = new Date(year, month + 1, 0).getDate();

    $('#monthYear').text(
        currentDate.toLocaleString('default', { month: 'long', year: 'numeric' })
    );

    let html = '';

    // Empty spaces
    for (let i = 0; i < firstDay; i++) {
        html += `<div></div>`;
    }

    let today = new Date().toISOString().split('T')[0];

    for (let i = 1; i <= lastDate; i++) {

        let dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(i).padStart(2,'0')}`;

        let isPast = dateStr < today;

        html += `
            <div class="${isPast ? 'disabled' : ''}" data-date="${dateStr}">
                ${i}
            </div>
        `;
    }

    $('#calendarDates').html(html);
}

// Click Date
$(document).on('click', '#calendarDates div:not(.disabled)', function(){

    $('#calendarDates div').removeClass('active');
    $(this).addClass('active');

    let date = $(this).data('date');

    loadSlots(date); // your existing function
});

// Month Navigation
$('#prevMonth').click(function(){
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

$('#nextMonth').click(function(){
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

// Init
renderCalendar();

let selectedBranch = null;
let selectedType = null;
let selectedSlot = null;

// Load branches
let branches = @json($branches);

branches.forEach(b => {
    $('#branchList').append(`
        <div class="card-select" data-id="${b.id}">
            <strong>${b.branchName ?? b.name}</strong>
            <div style="font-size:12px;color:gray;">Click to select</div>
        </div>
    `);
});

// Select branch
$(document).on('click', '#branchList .card-select', function(){

    $('#branchList .card-select').removeClass('active');
    $(this).addClass('active');

    selectedBranch = $(this).data('id');

    loadTypes();
});

// Load services
function loadTypes(){
    axios.get('/api/get-types', {
        params: { branch_id: selectedBranch }
    }).then(res => {

        $('#typeList').html('');

        res.data.data.forEach(type => {
            $('#typeList').append(`
                <div class="card-select" data-id="${type.id}">
                    ${type.name}
                </div>
            `);
        });

    });
}

// Select service
$(document).on('click', '#typeList .card-select', function(){

    $('#typeList .card-select').removeClass('active');
    $(this).addClass('active');

    selectedType = $(this).data('id');
});

// Calendar
flatpickr("#datePicker", {
    minDate: "today",
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr){
        loadSlots(dateStr);
    }
});

// Load slots
function loadSlots(date){

    if(!selectedBranch || !selectedType){
        alert('Select branch & service first');
        return;
    }

    axios.get('/api/slots', {
        params: {
            branch_id: selectedBranch,
            appointment_type_id: selectedType,
            date: date
        }
    }).then(res => {

        $('#slotsContainer').html('');

        if(res.data.data.length === 0){
            $('#slotsContainer').html('<p>No slots available</p>');
            return;
        }

        res.data.data.forEach(slot => {

            let cls = slot.is_full ? 'slot full' : 'slot';

            $('#slotsContainer').append(`
                <div class="${cls} fade-in"
                     data-start="${slot.start_time_db}"
                     data-end="${slot.end_time_db}">
                    ${slot.start_time}
                    <span style="float:right">${slot.available} left</span>
                </div>
            `);
        });

    });
}

// Select slot
$(document).on('click', '.slot:not(.full)', function(){

    $('.slot').removeClass('selected');
    $(this).addClass('selected');

    selectedSlot = {
        start: $(this).data('start'),
        end: $(this).data('end')
    };

    $('#bookingForm').removeClass('d-none').addClass('fade-in');
});

// Book
$('#bookBtn').click(function(){

    axios.post('/api/book', {
        branch_id: selectedBranch,
        appointment_type_id: selectedType,
        appointment_date: $('#datePicker').val(),
        start_time: selectedSlot.start,
        end_time: selectedSlot.end,
        patient_name: $('#patient_name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        consultation_topic: $('#consultation_topic').val()
    })
    .then(res => {
        alert(res.data.message);
        location.reload();
    })
    .catch(err => {
        alert(err.response.data.message);
    });

});

</script>
@endpush
