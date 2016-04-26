
@if (Session::has('error'))
    <div class="alert alert-success">
        <p>{{ Session::get('error') }}</p>
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
    </div>
@endif
<div class="content1">
<div class="panel panel-default register">
    <div class="panel-body">
        <p>This is a text line</p>
        <form method="POST" action="{{url('register')}}">
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
              <input type="password" class="form-control" name="password" placeholder="Password">              
            </fieldset>
            <fieldset class="form-group">
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">              
            </fieldset>
            <fieldset class="form-group">
              <input type="text" class="form-control" name="address" placeholder="Address">              
            </fieldset>
            <fieldset class="form-group">
              <input type="text" class="form-control" name="mobile" placeholder="Contact No.">              
            </fieldset>
            
            <input type="hidden" name="accesslevel" value="0">
            <input type="hidden" name="status" value="0">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<a href='login'>LogIn</a>
</div>

@if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif