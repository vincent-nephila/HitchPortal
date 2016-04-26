@extends('app')
@section('content')
<div class="container">
<p style="background-color:rgba(249,110,91,0.75);color:white;margin:12px;text-align:center;padding:20px">We have verified your identity.Congratulations you have completed the preliminary.</p>
<div class="panel panel-default register">
    <div class="panel-body">
        <form method="POST" action="{{url('confirmed/'.$user->id.'/'.$user->confirmation_code)}}">
            {!!csrf_field()!!}
            <fieldset class="form-group">
              <input type="password" class="form-control" name="password" placeholder="Password">              
            </fieldset>
            <fieldset class="form-group">
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">              
            </fieldset>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif

</div>
        

@stop