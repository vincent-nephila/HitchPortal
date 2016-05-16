@extends('own')
@section('content')
                    <h3 align="center">Make Reservation</h3>
                    <form method="POST" class="form-horizontal" action="{{url('/passenger/reservation')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}             
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Destination</label>
                            <div class="col-md-10">
                                <select class="form-control" name="route" onchange="findTrip(this.value)">
                                    <option value="" disabled hidden selected></option>
                                    @foreach($route as $routes)
                                    <option value="{{$routes->destinationPoint}}">{{$routes->destinationPoint}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </fieldset>                        
                        <div id="trip" style="height: 40vh;overflow-x: hidden;margin-left:10%;overflow-y: scroll;
    width: 80%;">
                        </div>
                        
                        <div id="seat">
                            </div>

                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    @if(count($errors)>0) 
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    @endif 

                  
<script>
function findTrip(destination) {
    $.ajax({ 
            type: "GET", 
            url: "/findtrip/"+destination, 
            success:function(data){   
                $('#seat').html("");
                $('#trip').html("");
                $('#trip').html(data);
                 }
            });
                      
}

function findSeat(trip) {
    //document.getElementById("bow").innerHTML = trip;
    $.ajax({ 
            type: "GET", 
            url: "/findseat/"+trip, 
            success:function(data){              
                
                $('#seat').html(data);
                 }
            });
                      
}
</script>
@stop