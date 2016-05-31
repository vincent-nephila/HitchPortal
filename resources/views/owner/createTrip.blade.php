@extends('own')
@section('content')
                    <h3 align="center">Trip Creation</h3>
                    <form method="POST" class="form-horizontal" action="{{url('/portal/owner/createTrip')}}" enctype="multipart/form-data">
                        {!!csrf_field()!!}
                        <fieldset class="form-group">
                            <label class="control-label col-md-2">Destination</label>
                            <div class="col-md-10">
                                <select class="form-control" name="destination" id="destination">
                                    <option value="" disabled hidden selected></option>
                                    @foreach($destination as $results)
                                    <option value="{{$results->id}}">{{$results->destination}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="form-group" id="pickUp">
                        </fieldset>                      

                        <fieldset class="form-group">
                                <label class="control-label col-md-2">Date:</label>
                                <div class="col-md-10"> 
                                    <input type="text" class="form-control" id="datepicker" name="date" >
                                </div>
                        </fieldset>
                        
                        <fieldset class="form-group ">
                                <label class="control-label col-md-2">Time:</label>
                                <div id="sample2" class="col-md-10">
                                    <input name="time" class="form-control"/>
                                </div>
                        </fieldset>
                        <label class="control-label col-md-2">Vehicle:</label>
                        <div  class="col-md-10" id="vehicles" >     
                            @foreach($vehicle as $vehicles)
                            <div style="max-height: 100px;width: 300px;" class="col-md-4 selection" id="{{$vehicles->vrDrId}}">
                                <img src="{{url('/uploads/vehicle/'.$vehicles->veFrontPic)}}" class="img-responsive" style="max-height: 100px;max-width: 350px;display: inline-block;">
                                <div style="display: inline-block;padding-left:10px;">
                                    {{$vehicles->vePlateNo}}<br>
                                    {{$vehicles->veMaker}} {{$vehicles->veModel}} {{$vehicles->veProYear}}<br>
                                    {{$vehicles->firstname}} {{$vehicles->lastname}}<br>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <input type="hidden" name="vehicle" id="driverVehicle">
                        
                        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    
                    
                    
    <script type="text/javascript">
        $(document).ready(function(){
            // find the input fields and apply the time select to them.
            $('#sample2 input').ptTimeSelect({
                onBeforeShow: function(i){
                    $('#sample2-data')
                        .append();
                },
                onClose: function(i) {
                    $('#sample2-data')
                        .append();
                }
            }); //end ptTimeSelect()
        }); // end ready()
        $('#destination').change(function(){
            $.ajax({
                type:"GET",
                url:'/getPickup/'+ $(this).val(),
                success:function(data){
                    $('#pickUp').html('');
                    $('#pickUp').html(data);
                }
            });
        });
        
        $("#vehicles").on("click", "div.selection", function(){
    $('.selection').css('background-color','rgba(0,0,0,0)');
    $(this).css('background-color','#0082C4');
    $('#driverVehicle').val($(this).attr('id'));
    
});
    </script>
                    @if(count($errors)>0) 
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    @endif 
@stop