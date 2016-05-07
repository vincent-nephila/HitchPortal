<!DOCUMENT HTML>
<html>
    <head>
        <link href="{{ asset('/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        
        
        
        <script src="{{ asset('/bootstrap/dist/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.slim.js') }}"></script>
        
        
 
        
  <script src="script.js"></script>
  <script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
        });
    });
</script>
        
    </head>
    <body>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
                <img src="{{asset('/images/hitch_logo.png')}}" class="img-responsive" style="width:50px;height:auto;">
            </div>
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">Page 1</a></li>
              <li><a href="#">Page 2</a></li> 
              <li><a href="#">Page 3</a></li> 
            </ul>
          </div>
        </nav>        
        
        <div class="container">
            @yield('content')
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <p class="text-muted"> Copyright 2016, Hitch Developers All Rights Reserved.</p>
            </div>
        </footer>
    </body>

</html>