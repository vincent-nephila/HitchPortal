<!DOCUMENT HTML>
<html>
    <head>
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        
        <script src="{{ asset('/jquery/dist/jquery.slim.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>

        <script src="{{ asset('/bootstrap/dist/js/bootstrap.js') }}"></script>
        <link href="{{ asset('/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">        
        
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet">
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
      <script src="{{ asset('jquery.ptTimeSelect.js') }}"></script>
      <link href="{{ asset('jquery.ptTimeSelect.css') }}" rel="stylesheet">
      
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="{{asset('fancyBox/source/jquery.fancybox.js?v=2.1.5')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('fancyBox/source/jquery.fancybox.css?v=2.1.5')}}" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="{{asset('fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}" />
	<script type="text/javascript" src="{{asset('fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="{{asset('fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7')}}" />
	<script type="text/javascript" src="{{asset('fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7')}}"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="{{asset('fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.6')}}"></script>      
        
 
        <script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
        
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
                <img src="{{asset('/images/HitchOfficialLogo.png')}}" class="img-responsive" style="width:50px;height:auto;">
            </div>
            <ul class="nav navbar-nav">
              <li><a href="/admin">Owners</a></li>
              <li><a href="/admin/driver">Drivers</a></li>
            </ul> 
            <ul class="nav navbar-nav navbar-right">
              <li ><a href="/logout">Logout</a></li>
            </ul>
          </div>
        </nav>        
        
        <div class="container-fluid">
            @yield('content')
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <p class="text-muted"> Copyright 2016, Hitch Developers All Rights Reserved.</p>
            </div>
        </footer>
    </body>

</html>