<!DOCUMENT HTML>
<html>
    <head>
        <link href="{{ asset('/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
        <!--link rel="stylesheet" href= "{{asset('/css/layout.css')}}"-->
        
        
        <script src="{{ asset('/bootstrap/dist/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.js') }}"></script>
        <script src="{{ asset('/jquery/dist/jquery.slim.js') }}"></script>
        
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


       <script>
      $(function() {
        $( "#datepicker" ).datepicker();
      });
      </script>

        
    </head>
    
    <body style="margin-bottom: 0px;">
                <div class="container-fluid" style="padding-left: 0px">

            <div class="col-md-3" style="background-color: #e65c00;color:black;height: 100vh;padding-left: 0px;padding-right: 0px">
                
                
                <hr>
                <div>Logout</div>
                <hr>
            </div>
            <div class="col-md-9">


                    <h3 align="center">Requirements</h3>
                    <p class="col-sm-offset-1">Please complete requirements to proceed to next step.</p>
                    <form method="POST" class="form-horizontal" action="{{url('portal/owner/requirement')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Birth date</label>
                            <div class="col-md-10">
                                <input type="text" id="datepicker" class="form-control" name="bdate" placeholder="Birth Date">
                            </div>
                        </fieldset>
                        <fieldset class="form-group">                   
                            <label class="control-label col-md-2">Address</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>
                        </fieldset>
                        <fieldset class="form-group"> 
                            <label class="control-label col-md-2">2x2 Picture</label>
                            <div class="col-md-10">
                                <input type="file" name="picture" class="form-control" placeholder="2x2 Picture">
                            </div>
                        </fieldset>
                        <fieldset class="form-group">   
                            <label class="control-label col-md-2">1st Valid Id</label>
                            <div class="col-md-10">
                                <input type="file" name="id1" class="form-control" placeholder="Valid ID 1">
                            </div>
                        </fieldset>
                        <fieldset class="form-group">   
                            <label class="control-label col-md-2">2nd Valid Id</label>
                            <div class="col-md-10">
                                <input type="file" name="id2" class="form-control" placeholder="Valid ID 2">
                            </div>
                        </fieldset>
                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">  Next >>  </button>
                        </div>
                    </form>
                    @if(count($errors)>0) 
@foreach($errors->all() as $error)
<li>{{$error}}</li>
@endforeach

@endif 
<div class="col-sm-offset-1">
<h5>Reminder</h5>
<hr>
<ol type="1">
    <li>Make sure the sent documents have a clear image of the file.</li>
    <li>Upload latest picture for your profile</li>
</ol>
</div>
        </div>
            </div>

    </body>
    
</html>