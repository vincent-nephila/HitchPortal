@extends('own')
@section('content')
Destination: {{$route->destination}}<br>
Pickup Point: {{$route->pointOrigin}}<br>
Fare (per seat): {{$route->fare}}<br>
Est. Time Travel: {{$route->estDuration}}<br>
<br>
<h3>Vehicle</h3>
Plate No: {{$vehicle[0]->vePlateNo}}<br>
Model: {{$vehicle[0]->veMaker}} {{$vehicle[0]->veModel}} {{$vehicle[0]->veProYear}}

<h3>Driver</h3>
Name: {{$vehicle[0]->firstname}} {{$vehicle[0]->lastname}}<br>
Plate No: {{$vehicle[0]->vePlateNo}}
@stop