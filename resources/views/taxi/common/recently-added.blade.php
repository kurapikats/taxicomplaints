@if (isset($taxis))
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="recently-added float-box">
            <h4>Recently Added</h4>
            <ul>
                @foreach ($taxis as $taxi)
                    <li class="show-taxi-link" data-id="{{ $taxi->id }}">
                    {{ $taxi->name }}
                    {!! link_to('#' . $taxi->id, $taxi->plate_number) !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-sm-3"></div>
@endif
