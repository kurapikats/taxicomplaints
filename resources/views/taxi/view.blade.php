@extends('layouts.master')

@section('page_styles')
    {!! Html::style('components/jquery-colorbox/example1/colorbox.css') !!}
@stop

@section('page_scripts')
    {!! Html::script('components/jquery-colorbox/jquery.colorbox-min.js') !!}

    <script type="text/javascript">
    $('a.gallery').colorbox({rel:'gal', photo: true, fixed:true});
    </script>
@stop

@section('content')

    Taxi Details<br>
    Plate Number: {{ $taxi->plate_number }}<br>
    Name: {{ $taxi->name }}<br>
    Description: {{ $taxi->description }}<br>
    Pictures: <br>
    <ul>
        @forelse ($taxi->taxi_pictures() as $picture)
            <li>
                <a class="gallery" rel="gal" href="{{ url($picture->path) }}"
                    target="_blank">
                    <img src="{{ url($picture->path) }}" width="100">
                </a>
            </li>
        @empty
            <li>No Pictures</li>
        @endforelse
    </ul>

    @if (count($taxi->taxi_complaints()->toArray()) > 0)
        <br>
        Complaints: <br>
        @foreach ($taxi->taxi_complaints() as $complaint)
            Complaint ID: <code>{{ str_pad($complaint->id, 10, "100", STR_PAD_LEFT) }}</code><br>
            Incident Date: {{ date('M d, Y', strtotime($complaint->incident_date)) }}<br>
            Incident Time:
            @if (!empty($complaint->incident_time))
                 {{ date('g:i a', strtotime($complaint->incident_time)) }}<br>
            @else
                N/A
            @endif
            <br>
            Incident Location: {{ $complaint->incident_location ?: 'N/A' }}<br>
            Notes: {{ $complaint->notes ?: 'N/A' }}<br>
            Driver's Name: {{ $complaint->drivers_name ?: 'N/A' }}<br>

            @if (Auth::user() && Auth::user()->role()->name == 'Admin')
                Valid: {{ $complaint->isValid() }}<br>
                Mail Sent: {{ $complaint->mailSent() }}<br>
            @endif

            <!-- reporter's info -->
            Reported By: {{ $complaint->user()->name }}<br>
            @if (Auth::user() && Auth::user()->role()->name == 'Admin')
                Contact #: {{ $complaint->user()->contact_number }}<br>
                Email: {{ $complaint->user()->email }}<br>
            @endif
            <br>

            Violations: <br>
            @foreach ($complaint->taxi_violations() as $violation)
                {{ $violation->violation()->name }}<br>
            @endforeach
            <hr>

            {!! Form::open(array('url' => 'mail')) !!}
                {!! csrf_field() !!}
                {!! Form::hidden('taxi_complaint_id', $complaint->id) !!}
                {!! Form::submit('Send Email') !!}
            {!! Form::close() !!}

            {!! link_to('#compose-email-' . $complaint->id, 'Compose Email',
                ['class' => 'compose-email']) !!}
            <br>
        @endforeach
    @endif

    {!! link_to('report/' . $taxi->id , 'Report New Complaints for this Taxi') !!}

@stop
