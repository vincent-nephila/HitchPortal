@extends('app')
@section('content')
                    <form method="POST" action="{{url('portal/owner/addCar')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}                  
                        <fieldset class="form-group">
                            <input id="input-1" type="date" class="form-control" name="bdate" placeholder="Birth Date">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="text" class="form-control" name="address" placeholder="Address">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="picture" class="form-control" placeholder="2x2 Picture">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="id1" class="form-control" placeholder="Valid ID 1">
                        </fieldset>
                        <fieldset class="form-group">                   
                            <input id="input-1" type="file" name="id2" class="form-control" placeholder="Valid ID 2">
                        </fieldset>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
@stop