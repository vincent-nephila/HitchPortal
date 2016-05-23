<!DOCUMENT HTML>
<html>
    <head>

        <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">

        
        <script src="{{ asset('/jquery/dist/jquery.slim.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>

        <script src="{{ asset('/bootstrap/dist/js/bootstrap.js') }}"></script>
        <link href="{{ asset('/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">        
        
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet">
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    

      <script src="{{ asset('jquery.selectable.js') }}"></script>
      <script src="{{ asset('jquery.ptTimeSelect.js') }}"></script>
      <link href="{{ asset('jquery.ptTimeSelect.css') }}" rel="stylesheet">
       <script>
      $(function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker2" ).datepicker();
        
      });
      </script>
        
    </head>
    
    <body style="margin-bottom: 0px;">
        <div class="container-fluid" style="padding-left: 0px;padding-right: 0px;">
            <div class="col-md-3" style="background-color:#0082c4;color:black;height: 100vh;padding-left: 0px;padding-right: 0px">

                
                    {!!$menu!!}
                
                <a class='btn btn-primary form-control menu-button' href='{{url('/logout')}}'><div>Logout</div></a>
            </div>
            <div class="col-md-9" style="height:100vh;overflow-x:hidden;overflow-y:scroll;background-color:#f9d796;">
@yield('content')
            </div>
        </div>

    </body>
    
</html>