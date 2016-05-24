@extends('own')
@section('content')
<h3>User Profile</h3>
<div style="padding-top:20px;">
<img src="{{url($pic)}}" style="height:auto;width:20%;">
<div style="padding-top:20px;">
    <div>Name: {{$user->lastname}}, {{$user->firstname}} {{$user->middlename}}</div>
    <div>E-mail: {{$user->email}}</div>
    <div>Address: {{$profile->address}}</div>
    <div>Mobile: {{$user->mobile}}</div>
</div>
</div>
@stop