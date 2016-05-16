@extends('own')
@section('content')

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
@stop