@extends('app')
@section('content')


<div class="container">
            <div class="row">
            <div class="col-md-12">
            </div>
            <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                                                <form class="form-horizontal" role="form" method="POST" action="{{ url('login') }}" style= "border-radius: 30px;">
						  {!! csrf_field() !!}

						<div class="form-group">
                                                </div> 
                                                
                                                  <div class="form-group">
                                                </div> 
                                                  
                                                  
                                                <div class="form-group">
							<label class="col-md-4 control-label" style="color: #ffffff">E-mail</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="email" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" style="color: #ffffff">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label style="color: #ffffff">
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Login</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}" style="color: #ffffff">Forgot Your Password?</a>
							</div>
						</div>
                                                  
                                                <div class="form-group">
                                                </div>
                                                  
                                                <div class="form-group">
                                                </div>   
                                                  
                                                  @if(count($errors)>0) 
                                                    @foreach($errors->all() as $error)
                                                    <li style="text-align:center">{{$error}}</li>
                                                    @endforeach

                                                    @endif
                                                  
                                                </form>
                </div>
                <div class="col-md-3">
                </div>
        </div>       
    </div>
</div>
@stop