@extends('layouts.master')

@section('content')
    Name: <strong>{{ $user->name }}</strong><br>
    Address: {{ $user->address }}<br>
    Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a><br>
    Contact Number: {{ $user->contact_number }}<br>
    Photo: <img src="{{ $user->photo }}" title="{{ $user->name }}"><br>
    Role: {{ $user->role()->name }}<br>

    @if (count($user->taxis()) > 0)
        Taxi's Reported: <br>
        @foreach ($user->taxis() as $taxi)
            {!! link_to('show/' . $taxi['id'],
            $taxi['plate_number'] . " - " . $taxi['name']) !!} <br>
        @endforeach
    @endif
@stop

