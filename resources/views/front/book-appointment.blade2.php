@extends('layouts.front')
@push('styles')
<style>
.pill {
    display: inline-block;
    padding: 10px 18px;
    border: 1px solid #ddd;
    border-radius: 50px;
    margin: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.pill.active {
    background: #000;
    color: #fff;
}

.slot {
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 8px;
    cursor: pointer;
    border-radius: 6px;
}

.slot.full {
    background: #f5f5f5;
    color: #999;
    cursor: not-allowed;
}

.slot.selected {
    background: #000;
    color: #fff;
}
</style>
@endpush
@section('content')

<div class="container py-5">

    <h3 class="mb-4">Book Appointment</h3>

    <!-- Branch -->
    <h5>Select Branch</h5>
    <div id="branchList" class="mb-4"></div>

    <!-- Appointment Type -->
    <h5>Select Service</h5>
    <div id="typeList" class="mb-4"></div>

    <div class="row">
        <!-- Calendar -->
        <div class="col-md-7">
            <h5>Select Date</h5>
            <input type="date" id="datePicker" class="form-control">
        </div>

        <!-- Slots -->
        <div class="col-md-5">
            <h5>Available Slots</h5>
            <div id="slotsContainer"></div>
        </div>
    </div>

    <!-- Form -->
    <div id="bookingForm" class="mt-4 d-none">
        <h5>Patient Details</h5>

        <input type="text" id="patient_name" placeholder="Full Name" class="form-control mb-2">
        <input type="email" id="email" placeholder="Email" class="form-control mb-2">
        <input type="text" id="phone" placeholder="Phone" class="form-control mb-2">
        <textarea id="consultation_topic" placeholder="Problem" class="form-control mb-2"></textarea>

        <button id="bookBtn" class="btn btn-primary w-100">Confirm Booking</button>
    </div>

</div>

@endsection
@push('scripts')
<script>
let selectedBranch = null;
let selectedType = null;
let selectedSlot = null;

// 🔹 Load Branches (pass from controller)
let branches = @json($branches);

branches.forEach(b => {
    $('#branchList').append(
        `<div class="pill" data-id="${b.id}">${b.branchName}</div>`
    );
});

// ✅ Branch Click
$(document).on('click', '#branchList .pill', function () {

    $('#branchList .pill').removeClass('active');
    $(this).addClass('active');

    selectedBranch = $(this).data('id');

    loadTypes();
});

// ✅ Load Appointment Types
function loadTypes() {

    axios.get('/api/get-types', {
        params: { branch_id: selectedBranch }
    }).then(res => {

        $('#typeList').html('');

        res.data.data.forEach(type => {
            $('#typeList').append(
                `<div class="pill" data-id="${type.id}">${type.name}</div>`
            );
        });

    });
}

// ✅ Select Type
$(document).on('click', '#typeList .pill', function () {

    $('#typeList .pill').removeClass('active');
    $(this).addClass('active');

    selectedType = $(this).data('id');
});

// ✅ Date Change → Load Slots
$('#datePicker').on('change', function () {

    let date = $(this).val();

    if (!selectedBranch || !selectedType) {
        alert('Please select branch & service first');
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

        if (res.data.data.length === 0) {
            $('#slotsContainer').html('<p>No slots available</p>');
            return;
        }

        res.data.data.forEach(slot => {

            let cls = slot.is_full ? 'slot full' : 'slot';

            $('#slotsContainer').append(`
                <div class="${cls}"
                    data-start="${slot.start_time_db}"
                    data-end="${slot.end_time_db}">
                    ${slot.start_time} (${slot.available} left)
                </div>
            `);
        });

    });
});

// ✅ Select Slot
$(document).on('click', '.slot:not(.full)', function () {

    $('.slot').removeClass('selected');
    $(this).addClass('selected');

    selectedSlot = {
        start: $(this).data('start'),
        end: $(this).data('end')
    };

    $('#bookingForm').removeClass('d-none');
});

// ✅ Book Appointment
$('#bookBtn').click(function () {

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
