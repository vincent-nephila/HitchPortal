@extends('own')
@section('content')
@if (Session::has('error'))
    <div class="alert alert-success">
        <p>{{ Session::get('error') }}</p>
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
    </div>
@endif
<div>
    <table class="table">
        <thead>
        <tr><th>Name</th><th>Status</th></tr>        
        </thead>
        <tbody>
            @foreach($driver as $drivers)                     
                <tr class="clickable-row" >
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
                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">    
                        <a href='/portal/owner/addDriver' class="btn btn-primary">Add</a>
                    </div>
</div>
@stop