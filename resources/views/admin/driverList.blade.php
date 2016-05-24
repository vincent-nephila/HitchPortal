@extends('admin')
@section('content')
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
@stop