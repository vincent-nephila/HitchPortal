@extends('app')
@section('content')
    <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    </div>  
                <div class="row">
                    <div class="col-md-7">
                        <div id="logo"></div>   
                    <!--<img src="{{asset('/images/hitch_logo.png')}}" class="logo">
                    -->
                    </div> 
                   
                    <div class="col-md-5" style= " background-color: #fd6a62/*rgba(0,0,0,0.5)*/; border-radius: 30px;">
                    <h1 style="color: #ffffff; font-family: Open Sans; " > SIGN UP</h1>
                    <a href="registerOwner"> <img src="{{asset('/images/VOwner.png')}}" class="plate img-responsive"></a>
                    <a href="registerPassenger"><img src="{{asset('/images/H2ride.png')}}" class="plate img-responsive "></a>
                    </div>
                             
                </div> 
            
                </div>
            </div>    
   
    </body>
    <!--html-->
    @stop