@extends('admin')
@section('content')

<div class="col-md-3">
<img src="{{url($pic)}}" style="height:auto;width:100%;">
</div>
<div class="col-md-9">
    <div>Name: {{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</div>
    <div>E-mail: {{$applicant->email}}</div>
    <div>Address: {{$profile->address}}</div>
    <div>Mobile: {{$applicant->mobile}}</div>
    <br>
@if($applicant->status == env('STATUS_APPROVAL'))
<button class='btn btn-success' onclick="approve({{$applicant->id}})"><div id="status">Approve</div></button>
@endif
   
</div>
<div>
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
<div>
    <table class="table">
        <thead>
        <tr><th>Plate No</th><th>Model</th><th>Status</th></tr>        
        </thead>
        <tbody>
            @foreach($vehicle as $vehicles)                     
                <tr class="clickable-row" data-href="/admin/vehicle/{{$vehicles->id}}">
                <td>{{$vehicles->vePlateNo}}</td><td> {{$vehicles->veModel}}</td><td> 
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