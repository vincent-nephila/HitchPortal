<!DOCUMENT HTML>
<html>
    <head>
        <link href="{{ asset('/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
          
        <script src="{{ asset('/bootstrap/dist/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.slim.js') }}"></script>
       
    </head>
    
    <body>
        <div class="container" style="padding: 15% 25%;">
            <div class="panel panel-default register" style="background-color: #fd6a62/*rgba(0,0,0,0.5)*/; border-radius: 30px; border: none; ">
                <div class="panel-body" style="background-color:none;">
                    <h3 align="center">Please complete all the requirements</h3>
                    <form method="POST" action="{{url('portal/owner/requirement')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                        <fieldset class="form-group">
                            <input type="date"  class="form-control" name="bdate" placeholder="Birth Date">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input type="text" class="form-control" name="address" placeholder="Address">
                        </fieldset>
                        <fieldset class="form-group"> 
                            <label>2x2 Picture</label>
                            <input type="file" name="picture" class="form-control" placeholder="2x2 Picture">
                        </fieldset>
                        <fieldset class="form-group">   
                            <label>1st Valid Id</label>
                            <input type="file" name="id1" class="form-control" placeholder="Valid ID 1">
                        </fieldset>
                        <fieldset class="form-group">   
                            <label>2nd Valid Id</label>
                            <input type="file" name="id2" class="form-control" placeholder="Valid ID 2">
                        </fieldset>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif 
                </div>
            </div>
        </div>
    </body>
</html>