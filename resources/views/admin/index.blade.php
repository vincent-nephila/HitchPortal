@extends('indexAdmin')
@section('content')
<div class="col-md-4"> 
    <div class="col-md-4">
    <h4 >Owner List</h4>
    </div>
    <div class="col-md-8" style="text-align:right;"><p style="margin-top: 10px;margin-bottom: 10px;" id="owner"><a href='#' id="2" class="choice pill-left">Registered</a><a href='#' id="1" class="choice">For Assessment</a><a href='#' id="3" class="choice pill-right">All</a> </p></div>
            <table class="table" style="page-break-inside: auto"><thead>
            <th>Name</th><th>Status</th></tr>        
            </thead>
            <tbody id="ownerList">
            @foreach($applicant as $applicants)                     
            <tr class="clickable-row" data-href="/admin/user/{{$applicants->id}}">
                <td>{{$applicants->lastname}}, {{$applicants->firstname}} {{$applicants->middlename}}</td><td style="text-align:center"> 
                @if ($applicants->status == env('STATUS_OK'))
                    {{$result="OK"}}
                @endif
                @if ($applicants->status == env('STATUS_APPROVAL'))
                    {{$result="FOR ASSESSMENT"}}
                @endif                    
                @if ($applicants->status == env('STATUS_PROCESS'))
                    {{$result="INC. REQUIREMENT"}}
                @endif                                    
                </td>
            </tr> 
            @endforeach
            </tbody>
            </table>
</div>
<div class="col-md-4">
    <div class="col-md-4">
    <h4 >Driver List</h4>
    </div>
    <div class="col-md-8" style="text-align:right;"><p style="margin-top: 10px;margin-bottom: 10px;" id="driver"><a href='#' class="choice pill-left" id="1">Registered</a><a href='#' class="choice" id="0">For Assessment</a><a href='#' class="choice pill-right" id="3">All</a> </p></div>

    <table class="table">
        <thead>
        <tr><th>Name</th><th>Status</th></tr>        
        </thead>
        <tbody id="driverList">
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
<div class="col-md-4">
    <div class="col-md-4">
    <h4 >Driver List</h4>
    </div>
    <div class="col-md-8" style="text-align:right;"><p style="margin-top: 10px;margin-bottom: 10px;" id="driver"><a href='#' class="choice pill-left" id="1">Registered</a><a href='#' class="choice" id="0">For Assessment</a><a href='#' class="choice pill-right" id="3">All</a> </p></div>

    <table class="table">
        <thead>
        <tr><th>Name</th><th>Status</th></tr>        
        </thead>
        <tbody id="driverList">
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
<script>
    $("#owner").on("click", "a.choice", function(){
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
        $(this).blur();
        
        $.ajax({
            type:"GET",
            url:"/filterOwner/"+ $(this).attr('id'),
            success:function(data){
                $('#ownerList').html('');
                $('#ownerList').html(data);
                
            }
        });
});

    $("#ownerList").on("click", "tr.clickable-row", function(){
        window.document.location = $(this).data("href");
});

    $("#driver").on("click", "a.choice", function(){
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
        $(this).blur();
        
        $.ajax({
            type:"GET",
            url:"/filterDriver/"+ $(this).attr('id'),
            success:function(data){
                $('#driverList').html('');
                $('#driverList').html(data);
                
            }
        });
});

    $("#ownerList").on("click", "tr.clickable-row", function(){
        window.document.location = $(this).data("href");
});
</script>
@stop