@extends('own')
@section('content')
<form method="POST" class='form-horizontal' action="{{url('/owner/updateDriver/'.$applicant->id)}}" enctype="multipart/form-data">
{!!csrf_field()!!}
<div style="padding-top:20px">
<div class="col-md-3">
  
    <img src="{{url($pic1)}}" style="height:auto;width:100%;" id="profile"> 
        <label for="pics" class="btn btn-primary upload" style="width:100%">Upload
    <input type="file" id="pics" name="pic" class="form-control inputfile"></label>

</div>
<div class="col-md-9">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <fieldset class="form-group editField">
                        <label class="col-md-2"><b>Name</b></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" style="width: 50%;display: inline-block;" name="firstname" value="{{$applicant->firstname}}" placeholder="First Name">
                                <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="middlename" value="{{$applicant->middlename}}" placeholder="Middle Name">
                                <input type="text" class="form-control" style="width: 50%;display: inline-block;" name="lastname" value="{{$applicant->lastname}}" placeholder="Last Name">
                                <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="extname" value="{{$applicant->extname}}" placeholder="Ext. Name">
                            </div>
                    </fieldset>                    
                </td>
            </tr>
            
            <tr>
                <td>
                    <fieldset class="form-group editField">
                            <label class="col-md-2"><b>E-mail</b></label>
                            <div class="col-md-10">
                                <input type="email" class="form-control" value="{{$applicant->email}}" name="email" >
                            </div>
                    </fieldset>                    
                </td>
            </tr>
            
            <tr>
                <td>
                    
                    <fieldset class="form-group editField">        
                            <label class="col-md-2"><b>Address:</b></label>
                            <div class="col-md-10"> 
                                <input type="text" class="form-control" value="{{$profile->address}}" name="address" >
                            </div>
                    </fieldset>                    
                    
                </td>
            </tr> 
            
            <tr>
                <td>
                    
                    <fieldset class="form-group editField">
                            <label class="col-md-2 editField"><b>Mobile</b>:</label>
                            <div class="col-md-10">                         
                                <input type="text" class="form-control" value="{{$applicant->mobile}}" name="mobile" > 
                            </div>
                    </fieldset>                                            
                </td>
            </tr>             
            <tr>
                <td>
                    
                    <fieldset class="form-group editField">
                            <label class="col-md-2 editField"><b>Birth Date</b>:</label>
                            <div class="col-md-10">                         
                                <input type="text" id="datepicker" class="form-control" value="{{$bdate}}" name="bdate" > 
                            </div>
                    </fieldset>                                            
                </td>
            </tr>                         
        </tbody>
    </table>
        <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <fieldset class="form-group editField">
                            <label class="col-md-2"><b>License No:</b></label>
                            <div class="col-md-4"> 
                                <input type="text" class="form-control" value="{{$profile->licNo}}" name="licNo" >
                            </div>                        
                            <label class="col-md-2"><b>Exp. Date:</b></label>
                            <div class="col-md-4"> 
                                <input type="text" id="datepicker2" class="form-control" value="{{$licExp}}" name="licenseExp" >
                            </div>
                    </fieldset>                                        
                </td>
            </tr>          
        </tbody>
    </table>
</div>
</div>    
<div class="col-md-12">
<h3>Documents</h3>
<a class="fancybox" rel="group" href="{{url($pic2)}}"><div style="display:inline-block;text-align: center;">
<img src="{{url($pic2)}}" id="licPic" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>License</b></h5>
<label for="lic" class="btn btn-primary upload" style="width:100%">Upload
    <input type="file" id="lic" name="lic" class="form-control inputfile"></label>
</div></a>
<a class="fancybox" rel="group" href="{{url($pic3)}}">
<div style="display:inline-block;text-align: center;">
<img src="{{url($pic3)}}" id="nbiPic" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>NBI</b></h5>
<label for="nbi" class="btn btn-primary upload" style="width:100%">Upload
    <input type="file" id="nbi" name="nbi" class="form-control inputfile"></label>
</div></a>
</div>
<div class="col-sm-offset-9 col-sm-3" style="text-align: right;">
                @if($applicant->status == 0)
                            <button type="submit" class="btn btn-primary">  Save  </button>
                            @endif
                            <a href="{{url('portal/owner/driver/'.$applicant->id)}}" class="btn btn-primary">  Cancel  </a>
                        </div>

@if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif
</div>
</form>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#pics").change(function(){
        readURL(this);
    });
    
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#licPic').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#lic").change(function(){
        readURL1(this);
    });
    
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#nbiPic').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#nbi").change(function(){
        readURL2(this);
    });    
</script>
@stop