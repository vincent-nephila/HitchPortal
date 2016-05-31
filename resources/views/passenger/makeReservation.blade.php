@extends('own')
@section('content')
                    <h3 align="center">Make Reservation</h3>
                    <form method="POST" class="form-horizontal" action="{{url('/passenger/reservation')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}             
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Destination</label>
                            <div class="col-md-10">
                                <select class="form-control"  name="route" onchange="findMeet(this.value)">
                                    <option value="" disabled hidden selected></option>
                                    @foreach($route as $routes)
                                    <option value="{{$routes->destination}}">{{$routes->destination}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group">
                                <label class="control-label col-md-2">Date:</label>
                                <div class="col-md-10"> 
                                    <input type="text" class="form-control" id="datepicker" name="date" >
                                </div>
                        </fieldset>
                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                            <div onclick='findTrip()' class="btn btn-primary">Search</div>
                        </div>                
                        
                        <div class="container" id="tripOption">
                        <div id="trip" class="selectable">
                        </div>
                        </div>
                        
                        <input type="hidden" id="tripId" name="trip" value="">


                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    @if(count($errors)>0) 
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    @endif 
                    <div id="test"></div>
                  
<script>

function findMeet(destination) {
    //$("#tripOption").css({'height':'380px','overflow-y':'scroll','width':'100%','padding-left':'165px'});
    
    $.ajax({ 
            type: "GET", 
            url: "/findmeet/"+destination, 
            success:function(data){
                $('#date').html("");
                $('#meet').html("");
                $('#meet').html(data);
                 }
            });
                      
}

function findDate() {
    //$("#tripOption").css({'height':'380px','overflow-y':'scroll','width':'100%','padding-left':'165px'});
    
    //alert($('select[name=route]').val());
    $.ajax({ 
            type: "GET", 
            url: "/finddate/"+$('select[name=route]').val()+"/"+$('select[name=meetPoint]').val(),
            success:function(data){
                $('#date').html("");
                $('#date').html(data);
                
                 }
            });
                      
}

function findTrip() {
    $("#tripOption").css({'max-height':'380px','overflow-y':'scroll','width':'100%','padding-left':'165px'});
    
    $.ajax({ 
            type: "GET", 
            url: "/finddate/"+$('select[name=route]').val()+"/"+$('input[name=date]').val(),
            success:function(data){
                $('#trip').html(data);
                 }
            });
                      
}

$("#trip").on("click", "div.item", function(){
    $('.item').css('background-color','aqua');
    $(this).css('background-color','green');
    $("#tripId").val($(this).attr('id'));
    var trip = $(this).attr('id');
        $.ajax({ 
            type: "GET", 
            url: "/findseat/"+trip, 
            success:function(data){                              
                $('#seat').html(data);
                 }
            });
        

});
</script>


@stop