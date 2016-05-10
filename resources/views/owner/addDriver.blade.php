@extends('own')
@section('content')

            <div class="panel panel-default register" style="background-color: #fd6a62/*rgba(0,0,0,0.5)*/; border-radius: 30px; border: none; ">
                <div class="panel-body" style="background-color:none;">                    
                    <form method="POST" action="{{url('/portal/owner/addDriver')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                    <fieldset class="form-group">
                    <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="firstname" placeholder="First Name">              
                    <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="middlename" placeholder="Middle Name">              
                    </fieldset>
                    <fieldset class="form-group">
                    <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="lastname" placeholder="Last Name">              
                    <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="ext" placeholder="Extension Name">              
                    </fieldset>
                    <fieldset class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="E-mail">              
                    </fieldset>
                    <fieldset class="form-group">
                    <input type="text" class="form-control" name="mobile" placeholder="Contact No.">              
                    </fieldset>                        
                        
                    <fieldset class="form-group">
                        <input type="date" id="datepicker" class="form-control" name="bdate" placeholder="Birth Date">
                    </fieldset>
                    <fieldset class="form-group">                   
                        <input type="text" class="form-control" name="address" placeholder="Address">
                    </fieldset>
                    <fieldset class="form-group">                   
                        <input type="text" class="form-control" name="licenseNo" placeholder="License No">
                    </fieldset>          
                    <fieldset class="form-group">
                        <input type="date" class="form-control" name="licExpDate" placeholder="License Exp Date">
                    </fieldset>                        
                    <fieldset class="form-group"> 
                        <label>Copy of License</label>
                        <input type="file" name="lic" class="form-control">
                    </fieldset>
                    <fieldset class="form-group">   
                        <label>NBI Clearance</label>
                        <input type="file" name="nbi" class="form-control">
                    </fieldset>
                    <fieldset class="form-group">   
                        <label>2x2 Picture</label>
                        <input type="file" name="pic" class="form-control">
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