@extends('admin')
@section('content')

<div class="col-md-3">
<img src="{{url($pic)}}" style="height:auto;width:100%;">
</div>
<div class="col-md-9">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <b>Name</b>: {{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}
                </td>
            </tr>
            
            <tr>
                <td>
                    <b>E-mail</b>: {{$applicant->email}}
                </td>
            </tr>
            @if($applicant->status == env('STATUS_OK'))
            <tr>
                <td>
                    <b>Address</b>: {{$profile->address}}
                    
                </td>
            </tr> 
            @endif
            <tr>
                <td>
                    <b>Mobile</b>: {{$applicant->mobile}}
                </td>
            </tr>             
        </tbody>
    </table>
@if($applicant->status == env('STATUS_APPROVAL'))
<button class='btn btn-success' onclick="approve({{$applicant->id}})"><div id="status">Approve</div></button>
@endif
@if($applicant->status == env('STATUS_OK'))
<div id="status" class="btn btn-success btn-dis">APPROVED</div>
@endif
</div>

<div class="col-md-12">
<h3>Documents</h3>
<a class="fancybox" rel="group" href="{{url($id1)}}"><div style="display:inline-block;text-align: center;">
<img src="{{url($id1)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Id 1</b></h5>
</div></a>
<a class="fancybox" rel="group" href="{{url($id2)}}">
<div style="display:inline-block;text-align: center;">
<img src="{{url($id2)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Id 2</b></h5>
</div></a>
</div>
<div class="col-md-6">
    <h4>Driver</h4>
    <table class="table">
        <thead>
        <tr><th>Name</th><th>Status</th></tr>        
        </thead>
        <tbody>
            @foreach($driver as $drivers)                     
                <tr class="clickable-row" data-href="/admin/driver/{{$drivers->id}}">
                <td>{{$drivers->lastname}}, {{$drivers->firstname}} {{$drivers->middlename}}</td><td> 
                @if ($drivers->acctStatus == env('DRIVER_OK'))
                    {{$result="OK"}}
                @endif
                @if ($drivers->acctStatus == env('DRIVER_PROCESS'))
                    {{$result="FOR ASSESSMENT"}}
                @endif                    
                @if ($drivers->acctStatus == env('DRIVER_SUSPENDED'))
                    {{$result="SUSPENDED"}}
                @endif                                    
                </td>
        </tr> 
            @endforeach
        </tbody>
    </table>    
</div>
<div class="col-md-6">
    <h4>Vehicle</h4>
    <table class="table">
        <thead>
        <tr><th>Plate No</th><th>Model</th><th>Status</th></tr>        
        </thead>
        <tbody>
            @foreach($vehicle as $vehicles)                     
                <tr class="clickable-row" data-href="/admin/vehicle/{{$vehicles->id}}">
                <td>{{$vehicles->vePlateNo}}</td><td>{{$vehicles->veMaker}} {{$vehicles->veModel}}</td><td> 
                @if ($vehicles->veApproved == env('VEHICLE_APPROVED'))
                    {{$result="OK"}}
                @endif
                @if ($vehicles->veApproved == env('VEHICLE_PROCESS'))
                    {{$result="FOR ASSESSMENT"}}
                @endif                    
                @if ($vehicles->veApproved == env('VEHICLE_REGISTRATION'))
                    {{$result="REGISTRATION PROB."}}
                @endif                                    
                @if ($vehicles->veApproved == env('VEHICLE_INSURANCE'))
                    {{$result="INSURANCE"}}
                @endif                                    
                @if ($vehicles->veApproved == env('VEHICLE_INCOMPLETE'))
                    {{$result="INC. REQUIREMENT"}}
                @endif                                    
                
                </td>
        </tr> 
            @endforeach
        </tbody>
    </table>    
</div>


<script>
function approve(applicant){
   // document.getElementById("status").innerHTML = applicant;
    $.ajax({
        type:"GET",
        url:"/approve/"+applicant,
        success:function(data){
                $('#status').html("");
                $('#status').html(data);            
        }
        
    });
    
}
</script>
@stop