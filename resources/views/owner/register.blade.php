
@extends('app')
@section('content')  
        
@if (Session::has('error'))
    <div class="alert alert-success">
        <p>{{ Session::get('error') }}</p>
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-success">
        <p>{{ Session::get('succes s') }}</p>
    </div>
@endif

<div class="container">
    <div class="row">
         <div class="col-md-12">
        </div> 
    </div> 
    <div class="row">        
            <div class="col-md-4">
            </div> 
        
            <div class="col-md-4">
              
               <div class="panel panel-default register" style="background-color: #fd6a62/*rgba(0,0,0,0.5)*/; border-radius: 30px; border: none; ">
               <div class="panel-body" style="background-color:none;">
                    <h3 style="color: #ffffff; font-family: Open Sans; margin:0 0 0 0;">SIGN-UP AS</h3>
                    <h1 style="color: #ffffff; font-family: Open Sans; margin:0 0 5px 15px;">OWNER</h1>
                    <form method="POST" action="{{url('registerOwner')}}">
                    {!!csrf_field()!!}
                    <fieldset class="form-group">
                    <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="firstname" placeholder="First Name">              
                    <input type="text" class="form-control" style="width: 49%;display: inline-block;" name="middlename" placeholder="Middle Name">              
                    </fieldset>
                    <fieldset class="form-group">
                    <input type="text" class="form-control" name="lastname" placeholder="Last Name">              
                    </fieldset>
                    <fieldset class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="E-mail">              
                    </fieldset>
                    <fieldset class="form-group">
                    <input type="text" class="form-control" name="mobile" placeholder="Contact No.">              
                    </fieldset>
                    <button type="submit" class="btn btn-primary">Submit</button>
          
                    </form>
          
                </div>
                </div>
            
            </div>
            <div class="col-md-4">
            </div>    
    </div>    
</div>

@if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif  
</body>

@stop