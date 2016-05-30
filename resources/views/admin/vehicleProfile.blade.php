@extends('admin')
@section('content')

<div class="col-md-3">
<img src="{{url($pic1)}}" style="height:auto;width:100%;">
<div></div>
</div>
<div class="col-md-9">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <b>Plate No</b>: {{$vehicle->vePlateNo}}
                </td>
            </tr>
            
            <tr>
                <td>
                    <b>Model</b>: {{$vehicle->veMaker}} {{$vehicle->veModel}} {{$vehicle->veProYear}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Color</b>: {{$vehicle->veColor}}
                </td>
            </tr>             
            <tr>
                <td>
                    <b>Operator</b>: {{$operator->firstname}} {{$operator->lastname}}
                </td>
            </tr>                         
        </tbody>
    </table>
    <a class="fancybox" rel="group1" href="{{url($pic1)}}"><img src="{{url($pic1)}}" style="height:auto;width:80px;"></a>
    <a class="fancybox" rel="group1" href="{{url($pic2)}}"><img src="{{url($pic2)}}" style="height:auto;width:80px;"></a>
    <a class="fancybox" rel="group1" href="{{url($pic3)}}"><img src="{{url($pic3)}}" style="height:auto;width:80px;"></a>
    <div>
@if($vehicle->veApproved == env('VEHICLE_PROCESS'))
<button class='btn btn-success' onclick="approve({{$vehicle->id}})"><div id="status">Approve</div></button>
@endif
@if($vehicle->veApproved == env('VEHICLE_APPROVED'))
<div id="status" class="btn btn-success btn-dis">APPROVED</div>
@endif
</div>
</div>
<div class="col-md-12">
<h3>Documents</h3>
<a class="fancybox" rel="group" href="{{url($or)}}"><div style="display:inline-block;text-align: center;">
<img src="{{url($or)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Official Receipt</b></h5>
</div></a>
<a class="fancybox" rel="group" href="{{url($cr)}}">
<div style="display:inline-block;text-align: center;">
<img src="{{url($cr)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Certificate</b></h5>
</div></a>
<a class="fancybox" rel="group" href="{{url($insr)}}">
<div style="display:inline-block;text-align: center;">
<img src="{{url($insr)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Insurance</b></h5>
</div></a>
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