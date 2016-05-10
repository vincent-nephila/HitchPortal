@extends('own')
@section('content')

            <div class="panel panel-default register" style="background-color: #fd6a62/*rgba(0,0,0,0.5)*/; border-radius: 30px; border: none; ">
                <div class="panel-body" style="background-color:none;">                    
                    <form method="POST" action="{{url('portal/owner/addVehicle')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                        <fieldset class="form-group">                   
                            <input id="input-1" type="text" class="form-control" name="plateNo" placeholder="Plate no.">
                        </fieldset>

                        <fieldset class="form-group">
                            <select class="form-control" id="mySelect" name="maker" onchange="getModel(this.value)">
                                <option value="" disabled hidden selected>Maker</option>
                                @foreach($result as $results)
                                <option value="{{$results->maker}}">{{$results->maker}}</option>
                                @endforeach 
                            </select>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <select class="form-control" name="model" placeholder="Model">
                                <option value="" disabled hidden selected>Model</option>
                                @foreach($model as $models)
                                <option value="{{$models->model}}">{{$models->model}}</option>
                                @endforeach 
                                
                            </select>
                        </fieldset>
                                                                                           
                        <fieldset class="form-group">                   
                            <input id="input-1" type="text" class="form-control" name="color" placeholder="Registered Color">
                        </fieldset>
                        
                        
                        <fieldset class="form-group">      
                            <label>Insurance</label>
                            <input id="input-1" type="file" name="insurance" class="form-control" placeholder="Insurance">
                        </fieldset>
                        <fieldset class="form-group"> 
                            <label>Registration</label>
                            <input id="input-1" type="file" name="registration" class="form-control">
                        </fieldset>
                        <fieldset class="form-group"> 
                            <label>Front View</label>
                            <input id="input-1" type="file" name="front" class="form-control">
                        </fieldset>
                        <fieldset class="form-group">     
                            <label>Side View</label>
                            <input id="input-1" type="file" name="side" class="form-control">
                        </fieldset>
                        <fieldset class="form-group">   
                            <label>Back View</label>
                            <input id="input-1" type="file" name="back" class="form-control">
                        </fieldset>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>


<div id="demo"></div>

<script src="{{ asset('ajax.js') }}"></script>


@if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif


@stop