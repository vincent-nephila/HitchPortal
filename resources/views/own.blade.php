<!DOCUMENT HTML>
<html>
    <head>
        <link href="{{ asset('/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
        <!--link rel="stylesheet" href= "{{asset('/css/layout.css')}}"-->
        
        
        <script src="{{ asset('/bootstrap/dist/js/bootstrap.js') }}"></script>
        <!--script src="{{ asset('jquery.js') }}"></script-->
        <script src="{{ asset('/jquery/dist/jquery.slim.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>
        
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


       <script>
      $(function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker2" ).datepicker();
      });
      </script>

        
    </head>
    
    <body style="margin-bottom: 0px;">
        <div class="container-fluid" style="padding-left: 0px;padding-right: 0px;">
            <div class="col-md-3" style="background-color: #e65c00;color:black;height: 100vh;padding-left: 0px;padding-right: 0px">                
                <div>
                    {!!$menu!!}
                </div>
                <a href='{{url('/logout')}}'><div>Logout</div></a>
                <hr>
            </div>
            <div class="col-md-9" style="height:100vh;overflow-x:hidden;overflow-y:scroll;">
@yield('content')
            </div>
        </div>

    </body>
    
</html>