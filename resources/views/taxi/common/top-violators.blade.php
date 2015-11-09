@if (isset($top_violators))
    <div class="col-sm-3"></div>
    <div class="top-violators float-box col-sm-6">
        <h4>Top Violators</h4>
        <ul>
        @foreach ($top_violators as $top_violator)
            <li class="show-taxi-link" data-id="{{ $top_violator->id }}">
                ({{ $top_violator->counter }})
                <a href="#">
                    {{ $top_violator->plate_number}}
                </a>
            {{ $top_violator->name }}</li>
        @endforeach
        </ul>
    </div>
    <div class="col-sm-3"></div>
@endif

