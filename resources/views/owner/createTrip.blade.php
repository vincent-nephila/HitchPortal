@extends('own')
@section('content')
                    <h3 align="center">Trip Creation</h3>
                    <form method="POST" class="form-horizontal" action="{{url('portal/owner/addTrip')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}             
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Destination</label>
                            <div class="col-md-10">
                                <select class="form-control" id="mySelect" name="route" onchange="getModel(this.value)">                                    
                                    <option value="" disabled hidden selected></option>
                                    @foreach($route as $routes)
                                    <option value="{{$routes->id}}">{{$routes->startPoint}} - {{$routes->destinationPoint}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </fieldset>                        
                        
                        <fieldset class="form-group">
                                <label class="control-label col-md-2">Date:</label>
                                <div class="col-md-10"> 
                                    <input type="text" id="datepicker" class="form-control" name="date" >
                                </div>
                        </fieldset>

                        <fieldset class="form-group">
                                <label class="control-label col-md-2">Date:</label>
                                <div class="col-md-10"> 
                                    <input type="text" id="timepicker1" class="form-control" name="date" >
                                </div>
                        </fieldset>                        

                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    @if(count($errors)>0) 
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    @endif 
@stop