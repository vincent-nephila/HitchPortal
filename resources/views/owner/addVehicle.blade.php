@extends('own')
@section('content')
                    <h3 align="center">Vehicle Registration Request</h3>
                    <form method="POST" class="form-horizontal" action="{{url('portal/owner/addVehicle')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                        <fieldset class="form-group">       
                            <label class="control-label col-md-2">Plate No.</label>
                            <div class="col-md-10">                            
                                <input id="input-1" type="text" class="form-control" name="plateNo" >
                            </div>
                        </fieldset>

                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Brand</label>
                            <div class="col-md-10">
                                <select class="form-control" id="mySelect" name="maker" onchange="getModel(this.value)">                                    
                                    <option value="" disabled hidden selected></option>
                                    @foreach($result as $results)
                                    <option value="{{$results->maker}}">{{$results->maker}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Model</label>
                            <div class="col-md-10" id="model">                            
                            <select class="form-control" name="model">
                                <option value="" disabled hidden selected></option>      
                            </select>
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Year</label>
                            <div class="col-md-10" id="year">                            
                            <!--select class="form-control" name="year">
                                <option value="" disabled hidden selected></option>      
                            </select-->
                            <input type="text" class="form-control" name="year">
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group">      
                            <label class="control-label col-md-2">Color</label>
                            <div class="col-md-10">                            
                                <input type="text" class="form-control" name="color">
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group">      
                            <label class="control-label col-md-2">Insurance</label>
                            <div class="col-md-10">                            
                                <input type="file" name="insurance" class="form-control">
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group">      
                            <label class="control-label col-md-2">Official Receipt:</label>
                            <div class="col-md-10">                            
                                <input type="file" name="receipt" class="form-control">
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group"> 
                            <label class="control-label col-md-2">Registration</label>
                            <div class="col-md-10">                            
                                <input id="input-1" type="file" name="registration" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset class="form-group"> 
                            <label class="control-label col-md-2">Front View</label>
                            <div class="col-md-10">                            
                                <input id="input-1" type="file" name="front" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset class="form-group">     
                            <label class="control-label col-md-2">Side View</label>
                            <div class="col-md-10"> 
                                <input id="input-1" type="file" name="side" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset class="form-group">   
                            <label class="control-label col-md-2">Rear View</label>
                            <div class="col-md-10"> 
                                <input id="input-1" type="file" name="back" class="form-control">
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

<div id="demo"></div>

<script>
function getModel(maker) {
    $.ajax({ 
            type: "GET", 
            url: "/addVehicle/"+maker, 
            success:function(data){              
                $('#model').html("");
                $('#model').html(data);
                 }
            }); 
                      
}
/*
function getYear(maker) {
    $.ajax({ 
            type: "GET", 
            url: "/addYear/"+maker, 
            success:function(data){  
                //alert("sample");
                $('#year').html("");
                $('#year').html(data);
                 }
            }); 
                      
}*/
</script>


@stop