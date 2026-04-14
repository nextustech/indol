@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{--
@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            notify()->error($error);
        @endphp
    @endforeach
@endif --}}
