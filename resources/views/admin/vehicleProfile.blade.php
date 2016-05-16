@extends('admin')
@section('content')

<div class="col-md-3">
<img src="{{url($pic1)}}" style="height:auto;width:100%;">
</div>
<div class="col-md-9">
    <div>Plate No: {{$vehicle->vePlateNo}}</div>
    <div>Brand: {{$vehicle->veMaker}}</div>
    <div>Model: {{$vehicle->veModel}}</div>
    <div>Color: {{$vehicle->veColor}}</div>
    <br>
@if($applicant->veApproved == env('DRIVER_PROCESS'))
<button class='btn btn-success' onclick="approve({{$applicant->id}})"><div id="status">Approve</div></button>
@endif
   
</div>

<script>
function approve(applicant){
   // document.getElementById("status").innerHTML = applicant;
    $.ajax({
        type:"GET",
        url:"/approveVehicle/"+applicant,
        success:function(data){
                $('#status').html("");
                $('#status').html(data);            
        }
        
    });
    
}
</script>
@stop