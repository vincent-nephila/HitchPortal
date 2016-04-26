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
        <div class="container-fluid">
            <div class="col-md-4" style="background-color: grey;color:black;">
                <div>{{$user->firstname}}, {{$user->lastname}}</div>
            </div>
            <div class="col-md-8">
                
            </div>
        </div>
    </body>
    
</html>