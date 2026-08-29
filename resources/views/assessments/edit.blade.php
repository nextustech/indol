@extends('layouts.backend')
@section('page-css')
<style>
    .section-card { margin-bottom: 1rem; }
    .section-card .card-header { padding: .5rem 1rem; cursor: pointer; }
    .section-card .card-header .fas { transition: transform .3s; }
    .section-card.collapsed .card-header .fas.fa-chevron-down { transform: rotate(-90deg); }
    .investigation-row, .exercise-row { margin-bottom: .5rem; padding-bottom: .5rem; border-bottom: 1px dashed #dee2e6; }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Edit Assessment - {{ $assessment->patient->name ?? '' }}</h5>
                        </div>
                        {{ Html()->form('PUT')->route('assessments.update', $assessment->id)->open() }}
                        <div class="card-body">
                            @include('errors.list')

                            <div class="card section-card">
                                <div class="card-header bg-secondary" data-toggle="collapse" data-target="#patientSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Patient Information</h6>
                                </div>
                                <div id="patientSection" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Patient</label>
                                                <input type="text" class="form-control" value="{{ $assessment->patient->name ?? 'N/A' }} ({{ $assessment->patient->patientId ?? 'N/A' }})" readonly>
                                                <input type="hidden" name="patient_id" value="{{ $assessment->patient_id }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Branch <span class="text-danger">*</span></label>
                                                <select name="branch_id" class="form-control" required>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ $assessment->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->branchName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Date <span class="text-danger">*</span></label>
                                                <input type="date" name="assessment_date" class="form-control" value="{{ $assessment->assessment_date->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <label>Type <span class="text-danger">*</span></label>
                                                <select name="type" class="form-control" required>
                                                    <option value="initial" {{ $assessment->type == 'initial' ? 'selected' : '' }}>Initial</option>
                                                    <option value="follow-up" {{ $assessment->type == 'follow-up' ? 'selected' : '' }}>Follow-up</option>
                                                    <option value="discharge" {{ $assessment->type == 'discharge' ? 'selected' : '' }}>Discharge</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="draft" {{ $assessment->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="completed" {{ $assessment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card section-card">
                                <div class="card-header bg-info" data-toggle="collapse" data-target="#ccSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Chief Complaints</h6>
                                </div>
                                <div id="ccSection" class="collapse show">
                                    <div class="card-body">
                                        <label>Add from list or type new</label>
                                        <select class="form-control complaint-tags mb-2" data-tags-type="complaint" data-placeholder="Add common complaints...">
                                            <option value=""></option>
                                            @foreach($complaints as $c)
                                                <option value="{{ $c }}">{{ $c }}</option>
                                            @endforeach
                                        </select>
                                        <textarea name="chief_complaints" id="ccTextarea" class="form-control" rows="4">{{ $assessment->chief_complaints }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card section-card">
                                <div class="card-header bg-info" data-toggle="collapse" data-target="#historySection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> History of Present Illness</h6>
                                </div>
                                <div id="historySection" class="collapse show">
                                    <div class="card-body">
                                        <textarea name="history_of_present_illness" class="form-control" rows="4">{{ $assessment->history_of_present_illness }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card section-card">
                                <div class="card-header bg-success" data-toggle="collapse" data-target="#examSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Objective Examination</h6>
                                </div>
                                <div id="examSection" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Observation</label>
                                                <textarea name="observation" class="form-control" rows="3">{{ $assessment->observation }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Palpation</label>
                                                <textarea name="palpation" class="form-control" rows="3">{{ $assessment->palpation }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Range of Motion</label>
                                                <textarea name="range_of_motion" class="form-control" rows="3">{{ $assessment->range_of_motion }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Muscle Strength</label>
                                                <textarea name="muscle_strength" class="form-control" rows="3">{{ $assessment->muscle_strength }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Special Tests</label>
                                                <select class="form-control special-tags mb-2" data-tags-type="special_test" data-placeholder="Add from list or type new...">
                                                    <option value=""></option>
                                                    @foreach($specialTests as $st)
                                                        <option value="{{ $st }}">{{ $st }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea name="special_tests" id="specialTestsTextarea" class="form-control" rows="3">{{ $assessment->special_tests }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Neurological</label>
                                                <textarea name="neurological" class="form-control" rows="3">{{ $assessment->neurological }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Postural Assessment</label>
                                                <textarea name="postural_assessment" class="form-control" rows="3">{{ $assessment->postural_assessment }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Clinical Impression</label>
                                                <select class="form-control clinical-tags mb-2" data-tags-type="clinical_impression" data-placeholder="Add from list or type new...">
                                                    <option value=""></option>
                                                    @foreach($clinicalImpressions as $ci)
                                                        <option value="{{ $ci }}">{{ $ci }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea name="clinical_impression" id="clinicalImpressTextarea" class="form-control" rows="3">{{ $assessment->clinical_impression }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Investigations --}}
                            <div class="card section-card">
                                <div class="card-header bg-warning" data-toggle="collapse" data-target="#investigationSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Investigations</h6>
                                </div>
                                <div id="investigationSection" class="collapse">
                                    <div class="card-body">
                                        <div id="investigations-container">
                                            @forelse($assessment->investigations as $i => $inv)
                                            <div class="investigation-row row">
                                                <div class="col-md-3">
                                                    <select name="investigations[{{ $i }}][type]" class="form-control inv-type-select" data-placeholder="Type (MRI, X-ray, etc.)">
                                                        <option value=""></option>
                                                        @foreach($investigationTypes as $invType)
                                                            <option value="{{ $invType }}" {{ $inv->type == $invType ? 'selected' : '' }}>{{ $invType }}</option>
                                                        @endforeach
                                                        @if($inv->type && !$investigationTypes->contains($inv->type))
                                                            <option value="{{ $inv->type }}" selected>{{ $inv->type }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="date" name="investigations[{{ $i }}][date]" class="form-control" value="{{ $inv->investigation_date ? $inv->investigation_date->format('Y-m-d') : '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="investigations[{{ $i }}][findings]" class="form-control" value="{{ $inv->findings }}" placeholder="Findings">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="investigations[{{ $i }}][facility]" class="form-control" value="{{ $inv->facility }}" placeholder="Facility">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-investigation"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="investigation-row row">
                                                <div class="col-md-3">
                                                    <select name="investigations[0][type]" class="form-control inv-type-select" data-placeholder="Type (MRI, X-ray, etc.)">
                                                        <option value=""></option>
                                                        @foreach($investigationTypes as $invType)
                                                            <option value="{{ $invType }}">{{ $invType }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="date" name="investigations[0][date]" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="investigations[0][findings]" class="form-control" placeholder="Findings">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="investigations[0][facility]" class="form-control" placeholder="Facility">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-investigation"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @endforelse
                                        </div>
                                        <button type="button" id="add-investigation" class="btn btn-sm btn-success mt-2"><i class="fa fa-plus"></i> Add Investigation</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Treatment Plan --}}
                            <div class="card section-card">
                                <div class="card-header bg-danger" data-toggle="collapse" data-target="#treatmentSection">
                                    <h6 class="mb-0"><i class="fas fa-chevron-down"></i> Treatment Plan</h6>
                                </div>
                                <div id="treatmentSection" class="collapse">
                                    <div class="card-body">
                                        @php $plan = $assessment->treatmentPlan; @endphp
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Short-term Goals</label>
                                                <textarea name="short_term_goals" class="form-control" rows="3" placeholder="e.g., Reduce pain to 3/10 in 2 weeks">{{ $plan->short_term_goals ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Long-term Goals</label>
                                                <textarea name="long_term_goals" class="form-control" rows="3" placeholder="e.g., Return to work without restriction in 8 weeks">{{ $plan->long_term_goals ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Precautions / Avoid</label>
                                                <select class="form-control precaution-tags mb-2" data-tags-type="precaution" data-placeholder="Add precautions...">
                                                    <option value=""></option>
                                                    @foreach($precautions as $p)
                                                        <option value="{{ $p }}">{{ $p }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea name="precautions" id="precautionTextarea" class="form-control" rows="3" placeholder="Forward bending, weight lifting, long sitting, etc.">{{ $plan->precautions ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Advice</label>
                                                <select class="form-control advice-tags mb-2" data-tags-type="advice" data-placeholder="Add advice...">
                                                    <option value=""></option>
                                                    @foreach($advices as $a)
                                                        <option value="{{ $a }}">{{ $a }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea name="advice" id="adviceTextarea" class="form-control" rows="3" placeholder="Posture change, LS belt, western toilet, sleep position, etc.">{{ $plan->advice ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <label>Follow-up Instructions</label>
                                                <textarea name="follow_up_instructions" class="form-control" rows="2" placeholder="Frequency of visits, next review date...">{{ $plan->follow_up_instructions ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Exercises --}}
                                        <hr>
                                        <h6>Exercise Prescription</h6>
                                        <div id="exercises-container">
                                            @php $exCount = 0; @endphp
                                            @if($plan && $plan->exercises->count() > 0)
                                                @foreach($plan->exercises as $ex)
                                            <div class="exercise-row row">
                                                <div class="col-md-3">
                                                    <input type="hidden" name="exercises[{{ $exCount }}][id]" value="{{ $ex->id }}">
                                                    <select name="exercises[{{ $exCount }}][exercise_name]" class="form-control ex-name-select" data-placeholder="Exercise name">
                                                        <option value=""></option>
                                                        @foreach($exerciseNames as $exName)
                                                            <option value="{{ $exName }}" {{ $ex->exercise_name == $exName ? 'selected' : '' }}>{{ $exName }}</option>
                                                        @endforeach
                                                        @if($ex->exercise_name && !$exerciseNames->contains($ex->exercise_name))
                                                            <option value="{{ $ex->exercise_name }}" selected>{{ $ex->exercise_name }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[{{ $exCount }}][sets]" class="form-control" value="{{ $ex->sets }}" placeholder="Sets">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[{{ $exCount }}][repetitions]" class="form-control" value="{{ $ex->repetitions }}" placeholder="Reps">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[{{ $exCount }}][frequency]" class="form-control" value="{{ $ex->frequency }}" placeholder="Frequency">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[{{ $exCount }}][duration]" class="form-control" value="{{ $ex->duration }}" placeholder="Duration">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="exercises[{{ $exCount }}][category]" class="form-control ex-category-select" data-placeholder="Category">
                                                        <option value=""></option>
                                                        @foreach($exerciseCategories as $cat)
                                                            <option value="{{ $cat }}" {{ $ex->category == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                                        @endforeach
                                                        @if($ex->category && !$exerciseCategories->contains($ex->category))
                                                            <option value="{{ $ex->category }}" selected>{{ ucfirst($ex->category) }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                                    @php $exCount++; @endphp
                                                @endforeach
                                            @else
                                            <div class="exercise-row row">
                                                <div class="col-md-3">
                                                    <select name="exercises[0][exercise_name]" class="form-control ex-name-select" data-placeholder="Exercise name">
                                                        <option value=""></option>
                                                        @foreach($exerciseNames as $exName)
                                                            <option value="{{ $exName }}">{{ $exName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[0][sets]" class="form-control" placeholder="Sets">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[0][repetitions]" class="form-control" placeholder="Reps">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="exercises[0][frequency]" class="form-control" placeholder="Frequency">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="exercises[0][duration]" class="form-control" placeholder="Duration">
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="exercises[0][category]" class="form-control ex-category-select" data-placeholder="Category">
                                                        <option value=""></option>
                                                        @foreach($exerciseCategories as $cat)
                                                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                                @php $exCount = 1; @endphp
                                            @endif
                                        </div>
                                        <button type="button" id="add-exercise" class="btn btn-sm btn-success mt-2"><i class="fa fa-plus"></i> Add Exercise</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Assessment</button>
                            <a href="{{ route('assessments.show', $assessment->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                        {{ Html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(function() {
    $('.section-card .card-header').click(function() {
        $(this).closest('.section-card').toggleClass('collapsed');
    });

    function initAddIfNotFound($el, type) {
        $el.select2({
            width: '100%',
            tags: true,
            placeholder: $el.data('placeholder') || 'Select',
            createTag: function(params) {
                return { id: params.term, text: params.term, isNew: true };
            }
        });

        $el.on('select2:select', function(e) {
            var data = e.params.data;
            if (!data.isNew) return;

            if (!confirm('"' + data.text + '" not found. Add to master list?')) {
                $el.val('').trigger('change');
                return;
            }

            $.post('{{ route('dropdown-options.quick') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                name: data.text
            }).done(function(res) {
                $el.val(res.name).trigger('change');
            }).fail(function() {
                alert('Could not add value.');
                $el.val('').trigger('change');
            });
        });
    }

    function initTagsMergedTextarea($select, $textarea, type) {
        $select.select2({
            width: '100%',
            multiple: true,
            tags: true,
            placeholder: $select.data('placeholder') || 'Select or type...',
            tokenSeparators: [',', '\n']
        });

        function syncTextarea() {
            var vals = $select.val() || [];
            $textarea.val(vals.join('\n'));
        }

        var existing = $textarea.val() ? $textarea.val().split(/[\n,]+/).map(function(s) { return $.trim(s); }).filter(Boolean) : [];
        $select.val(existing).trigger('change');

        $select.on('select2:select', function(e) {
            var data = e.params.data;

            if (!data.isNew) {
                syncTextarea();
                return;
            }

            var raw = data.text;
            if (!confirm('"' + raw + '" not found. Add to master list?')) {
                var cur = $select.val() || [];
                $select.val(cur.filter(function(v) { return v !== raw; })).trigger('change');
                syncTextarea();
                return;
            }

            $.post('{{ route('dropdown-options.quick') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                name: raw
            }).done(function(res) {
                var cur = $select.val() || [];
                var idx = cur.lastIndexOf(raw);
                if (idx !== -1) cur[idx] = res.name;
                $select.val(cur).trigger('change');
                syncTextarea();
            }).fail(function() {
                var cur = $select.val() || [];
                $select.val(cur.filter(function(v) { return v !== raw; })).trigger('change');
                syncTextarea();
                alert('Could not add value.');
            });
        });

        $select.on('select2:unselect', syncTextarea);
    }

    initAddIfNotFound($('.inv-type-select'), 'investigation_type');
    initAddIfNotFound($('.ex-name-select'), 'exercise_name');
    initAddIfNotFound($('.ex-category-select'), 'exercise_category');

    initTagsMergedTextarea($('.complaint-tags'), $('#ccTextarea'), 'complaint');
    initTagsMergedTextarea($('.special-tags'), $('#specialTestsTextarea'), 'special_test');
    initTagsMergedTextarea($('.clinical-tags'), $('#clinicalImpressTextarea'), 'clinical_impression');
    initTagsMergedTextarea($('.precaution-tags'), $('#precautionTextarea'), 'precaution');
    initTagsMergedTextarea($('.advice-tags'), $('#adviceTextarea'), 'advice');

    var invIndex = {{ max($assessment->investigations->count(), 1) }};
    $('#add-investigation').click(function() {
        var html = '<div class="investigation-row row">' +
            '<div class="col-md-3"><select name="investigations[' + invIndex + '][type]" class="form-control inv-type-select" data-placeholder="Type">' +
            '<option value=""></option>@foreach($investigationTypes as $invType)<option value="{{ $invType }}">{{ $invType }}</option>@endforeach</select></div>' +
            '<div class="col-md-2"><input type="date" name="investigations[' + invIndex + '][date]" class="form-control"></div>' +
            '<div class="col-md-4"><input type="text" name="investigations[' + invIndex + '][findings]" class="form-control" placeholder="Findings"></div>' +
            '<div class="col-md-2"><input type="text" name="investigations[' + invIndex + '][facility]" class="form-control" placeholder="Facility"></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-investigation"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#investigations-container').append(html);
        initAddIfNotFound($('#investigations-container .investigation-row:last .inv-type-select'), 'investigation_type');
        invIndex++;
    });

    $(document).on('click', '.remove-investigation', function() {
        $(this).closest('.investigation-row').remove();
    });

    var exIndex = {{ $exCount }};
    $('#add-exercise').click(function() {
        var html = '<div class="exercise-row row">' +
            '<div class="col-md-3"><select name="exercises[' + exIndex + '][exercise_name]" class="form-control ex-name-select" data-placeholder="Exercise name">' +
            '<option value=""></option>@foreach($exerciseNames as $exName)<option value="{{ $exName }}">{{ $exName }}</option>@endforeach</select></div>' +
            '<div class="col-md-2"><input type="text" name="exercises[' + exIndex + '][sets]" class="form-control" placeholder="Sets"></div>' +
            '<div class="col-md-1"><input type="text" name="exercises[' + exIndex + '][repetitions]" class="form-control" placeholder="Reps"></div>' +
            '<div class="col-md-2"><input type="text" name="exercises[' + exIndex + '][frequency]" class="form-control" placeholder="Frequency"></div>' +
            '<div class="col-md-1"><input type="text" name="exercises[' + exIndex + '][duration]" class="form-control" placeholder="Duration"></div>' +
            '<div class="col-md-2"><select name="exercises[' + exIndex + '][category]" class="form-control ex-category-select" data-placeholder="Category">' +
            '<option value=""></option>@foreach($exerciseCategories as $cat)<option value="{{ $cat }}">{{ ucfirst($cat) }}</option>@endforeach</select></div>' +
            '<div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-exercise"><i class="fa fa-times"></i></button></div>' +
            '</div>';
        $('#exercises-container').append(html);
        initAddIfNotFound($('#exercises-container .exercise-row:last .ex-name-select'), 'exercise_name');
        initAddIfNotFound($('#exercises-container .exercise-row:last .ex-category-select'), 'exercise_category');
        exIndex++;
    });

    $(document).on('click', '.remove-exercise', function() {
        $(this).closest('.exercise-row').remove();
    });
});
</script>
@endsection
