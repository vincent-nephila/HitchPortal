@extends('own')
@section('content')
<div>
    <table class="table table-borderless" id="table">
        <thead>
        <tr><th>Plate No</th><th>Model</th><th>Status</th><th>Driver</th></tr>        
        </thead>
        <tbody>
            @foreach($vehicle as $vehicles)                     
                <tr class="clickable-row vehicle" id="{{$vehicles->ve_id}}">
                <td>{{$vehicles->vePlateNo}}</td><td> {{$vehicles->veMaker}} {{$vehicles->veModel}} {{$vehicles->veProYear}}</td><td> 
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
                <td id="assign">
                    @if($vehicles->veApproved == env('VEHICLE_APPROVED'))
                        @if(is_null($vehicles->drId))
                        Assign
                        @else
                           {{ $vehicles->firstname}}
                        @endif
                    @else
                        -
                    @endif
                </td>
        </tr> 
            @endforeach
        </tbody>
    </table>    
                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">    
                        <a href='/portal/owner/addVehicle' class="btn btn-primary">Add</a>
                    </div>    
</div>
@stop