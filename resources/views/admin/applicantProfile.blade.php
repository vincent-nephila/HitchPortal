@extends('admin')
@section('content')
{{$applicant->lastname}},{{$applicant->firstname}}<br>
Mobile:{{$applicant->mobile}}

<img src="{{url($pic)}}">

@stop