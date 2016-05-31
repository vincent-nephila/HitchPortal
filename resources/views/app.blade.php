<!DOCUMENT HTML>
<html>
    <head>
        <link href="{{ asset('/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
        <link rel="stylesheet" href= "{{asset('/css/layout.css')}}">
        
        
        <script src="{{ asset('/bootstrap/dist/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.slim.js') }}"></script>
        
  <script src="script.js"></script>
        
    </head>
    <body>
        
            
            <div role="navigation" class="navbar navbar-default" style = "border:none;" id='cssmenu'>
        
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div> 
                
               <div id="navbarCollapse" class="navbar-collapse collapse ">
                        <ul class="nav navbar-nav">
                        <li><a href='/'style="background-color: #F9D796;"><span>Home</span></a></li>
                        <!--<li><a href='#'><span>Company</span></a></li>
                        <li><a href='#'><span>Contact</span></a></li> -->
                
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                        <li><a href ="login" style="background-color: #F9D796;" >Log In</a></li>
                        </ul>
                </div>         
            </div>
    
        <!-- <div class="container_fluid"> -->
            @yield('content')
        <!--</div>-->
        <footer class="footer">
            <div class="container_fluid">
                <p class="text-muted"> Copyright 2016, Hitch Developers All Rights Reserved.</p>
            </div>
        </footer>
    </body>

</html>