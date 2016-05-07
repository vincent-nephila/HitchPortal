@extends('app')
@section('content')
<div class="container" style="padding: 15% 25%;">
            <div class="panel panel-default register" style="background-color: #fd6a62/*rgba(0,0,0,0.5)*/; border-radius: 30px; border: none; ">
                <div class="panel-body" style="background-color:none;">                    
                    <form method="POST" action="{{url('portal/owner/requirement')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                        <fieldset class="form-group">                   
                            <input id="input-1" type="text" class="form-control" name="PlateNo." placeholder="Plate no.">
                        </fieldset>

                        <fieldset class="form-group">
                            <select class="form-control" name="maker">
                                @foreach($result as $results)
                                <option value="{{$results->maker}}">{{$results->maker}}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        
                        <fieldset class="form-group">                   
                            <input id="input-1" type="text" class="form-control" name="Color" placeholder="Color">
                        </fieldset>
                        
                        
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="Insurance" class="form-control" placeholder="Insurance">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="registration  " class="form-control" placeholder="Valid ID 1">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="front" class="form-control" placeholder="Valid ID 2">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="side" class="form-control" placeholder="Valid ID 2">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="back" class="form-control" placeholder="Valid ID 2">
                        </fieldset>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

@stop