@extends('layout')
@section('content')

    @foreach($cities as $city)
        <h2>In {{$city->name}} the current weather of the day is: <u>{{$city->forecast}}</u></h2>
    @endforeach

@endsection
