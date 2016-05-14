@extends('own')
@section('content')
      
    <h3 align="center">Driver Registration Request</h3>
                    <form method="POST" class='form-horizontal' action="{{url('/portal/owner/addDriver')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                    <fieldset class="form-group">
                            <label class="control-label col-md-2">Name</label>
                            <div class="col-md-10">                         
                                <input type="text" class="form-control" style="width: 50%;display: inline-block;" name="firstname" placeholder="First Name">              
                                <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="middlename" placeholder="Middle Name">              
                            </div>
                    </fieldset>
                    <fieldset class="form-group">
                                                    <label class="control-label col-md-2"></label>
                            <div class="col-md-10"> 
                                <input type="text" class="form-control" style="width: 50%;display: inline-block;" name="lastname" placeholder="Last Name">              
                                <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="ext" placeholder="Extension Name">              
                            </div>
                    </fieldset>
                    <fieldset class="form-group">
                            <label class="control-label col-md-2">E Mail</label>
                            <div class="col-md-10">                         
                                <input type="email" class="form-control" name="email" >              
                            </div>
                    </fieldset>
                    <fieldset class="form-group">
                            <label class="control-label col-md-2">Contact No.</label>
                            <div class="col-md-10">                         
                                <input type="text" class="form-control" name="mobile" > 
                            </div>
                    </fieldset>                        
                    <fieldset class="form-group">
                            <label class="control-label col-md-2">Birth Date</label>
                            <div class="col-md-10"> 
                                <input type="text" id="datepicker" class="form-control" name="bdate" >
                            </div>
                    </fieldset>
                    <fieldset class="form-group">        
                            <label class="control-label col-md-2">Address</label>
                            <div class="col-md-10"> 
                                <input type="text" class="form-control" name="address" >
                            </div>
                    </fieldset>
                    <fieldset class="form-group">                   
                            <label class="control-label col-md-2">License No.</label>
                            <div class="col-md-10">                         
                                <input type="text" class="form-control" name="licNo" >
                            </div>
                    </fieldset>          
                    <fieldset class="form-group">
                                                    <label class="control-label col-md-2">Expiration Date</label>
                            <div class="col-md-10">                                                 
                        <input type="text" id="datepicker2" class="form-control" name="licExpDate">
                            </div>
                    </fieldset>                        
                    <fieldset class="form-group"> 
                                                                            <label class="control-label col-md-2">Copy of License</label>
                            <div class="col-md-10">                                                 
                        <input type="file" name="lic" class="form-control">
                            </div>
                    </fieldset>
                    <fieldset class="form-group">   
                                                                            <label class="control-label col-md-2">NBI Clearance</label>
                            <div class="col-md-10">                                                 
                        <input type="file" name="nbi" class="form-control">
                            </div>
                    </fieldset>
                    <fieldset class="form-group">   
                                                                            <label class="control-label col-md-2">2x2 Picture</label>
                            <div class="col-md-10">                                                 
                        <input type="file" name="pic" class="form-control">
                            </div>
                    </fieldset>
                    <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">    
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>


<div id="demo"></div>

<script src="{{ asset('ajax.js') }}"></script>


@if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif


@stop