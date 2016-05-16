@extends('own')
@section('content')
                    <h3 align="center">Trip Creation</h3>
                    <form method="POST" class="form-horizontal" action="{{url('/portal/owner/createTrip')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}             
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Destination</label>
                            <div class="col-md-10">
                                <select class="form-control" name="route">                                    
                                    @foreach($route as $routes)
                                    <option value="{{$routes->id}}">{{$routes->startPoint}} - {{$routes->destinationPoint}}</option>
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
                        
                        <fieldset class="form-group ">
                                <label class="control-label col-md-2">Time:</label>
                                <div id="sample2" class="col-md-10">
                                    <input name="time" class="form-control"/>
                                </div>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Vehicle</label>
                            <div class="col-md-10">
                                <select class="form-control" id="mySelect" name="vehicle" onchange="getModel(this.value)">                                    
                                    @foreach($vehicle as $results)
                                    <option value="{{$results->id}}">{{$results->vePlateNo}}-{{$results->veModel}}</option>
                                    @endforeach 
                                </select>                                
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Driver</label>
                            <div class="col-md-10">
                                <select class="form-control" name="driver">                                    
                                    @foreach($drivers as $result)
                                    <option value="{{$result->id}}">{{$result->lastname}}, {{$result->firstname}}</option>
                                    @endforeach 
                                </select>                                
                            </div>
                        </fieldset>                      
                        
                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    
                    
                    
    <script type="text/javascript">
        $(document).ready(function(){
            // find the input fields and apply the time select to them.
            $('#sample2 input').ptTimeSelect({
                onBeforeShow: function(i){
                    $('#sample2-data')
                        .append();
                },
                onClose: function(i) {
                    $('#sample2-data')
                        .append();
                }
            }); //end ptTimeSelect()
        }); // end ready()
    </script>
                    @if(count($errors)>0) 
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    @endif 
@stop