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
    <h3>Scheduled Trip</h3>
    <table class="table">
        <thead>
        <tr><th>Date</th><th>Time</th><th>Destination</th><th>Pick up</th></tr>        
        </thead>
        <tbody>
            @foreach($results as $result)                     
                <tr class="clickable-row" >
                <td>{{$result->date}}</td>
                <td>{{$result->time}}</td>
                <!--td>{{$result->destinationPoint}}</td>
                <td>{{$result->startPoint}}</td-->
        </tr> 
            @endforeach
        </tbody>
    </table>    
                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">    
                        <a href='/passenger/reservation' class="btn btn-primary">Add</a>
                    </div>
</div>
@stop