@extends('admin')
@section('content')

<div class="col-md-3">
<img src="{{url($pic)}}" style="height:auto;width:100%;">
</div>
<div class="col-md-9">
    <div><h3>{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</h3></div>
    <hr>
    <div><b>E-mail:</b> {{$applicant->email}}</div>
    <div><b>Address:</b> {{$profile->address}}</div>
    <div><b>Mobile:</b> {{$applicant->mobile}}</div>
    <div><b>Operator: </{{$operator->firstname}} {{$operator->lastname}}</div>
    <br>
@if($applicant->acctStatus == env('DRIVER_PROCESS'))
<button class='btn btn-success' onclick="approve({{$applicant->id}})"><div id="status">Approve</div></button>
@endif
   
</div>

<script>
function approve(applicant){
   // document.getElementById("status").innerHTML = applicant;
    $.ajax({
        type:"GET",
        url:"/approveDriver/"+applicant,
        success:function(data){
                $('#status').html("");
                $('#status').html(data);            
        }
        
    });
    
}
</script>
@stop