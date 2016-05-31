@extends('own')
@section('content')
<div style="padding:20px">
<div class="col-md-3">
<img src="{{url($pic1)}}" style="height:auto;width:100%;">
<div></div>
</div>
<div class="col-md-9">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <b>Plate No</b>: {{$vehicle->vePlateNo}}
                </td>
            </tr>
            
            <tr>
                <td>
                    <b>Model</b>: {{$vehicle->veMaker}} {{$vehicle->veModel}} {{$vehicle->veProYear}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Color</b>: {{$vehicle->veColor}}
                </td>
            </tr>             
            <tr>
                <td>
                    <b>Operator</b>: {{$operator->firstname}} {{$operator->lastname}}
                </td>
            </tr>                         
        </tbody>
    </table>
    <a class="fancybox" rel="group1" href="{{url($pic1)}}"><img src="{{url($pic1)}}" style="height:auto;width:80px;"></a>
    <a class="fancybox" rel="group1" href="{{url($pic2)}}"><img src="{{url($pic2)}}" style="height:auto;width:80px;"></a>
    <a class="fancybox" rel="group1" href="{{url($pic3)}}"><img src="{{url($pic3)}}" style="height:auto;width:80px;"></a>

</div>
<div class="col-md-6">
<h4>Documents</h4>
<a class="fancybox" rel="group" href="{{url($or)}}"><div style="display:inline-block;text-align: center;">
<img src="{{url($or)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Official</b></h5>
</div></a>
<a class="fancybox" rel="group" href="{{url($cr)}}">
<div style="display:inline-block;text-align: center;">
<img src="{{url($cr)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Certificate</b></h5>
</div></a>
<a class="fancybox" rel="group" href="{{url($insr)}}">
<div style="display:inline-block;text-align: center;">
<img src="{{url($insr)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>Insurance</b></h5>
</div></a>
</div>
    <div class="col-md-6">
        
        <h4>Driver</h4>
        <div id="driverPad">
        @if(is_null($driver[0]->drId))
               <div class="btn btn-default myBtn2" >Assign Driver</div>         
         @else
         <img src="{{url($drProfile)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;display:inline-block">
         <div style="display: inline-block;" id="withDriver">{{$driver[0]->firstname}} {{$driver[0]->lastname}} <br><div class="btn btn-default myBtn">Change Driver</div></div>
         @endif
         </div>
    </div> 
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">×</span>
      <h3>Assign Driver</h3>
    </div>
    <div class="modal-body">
    </div>

  </div>

</div>
</div>    
<script>
var modal = document.getElementById('myModal');    
var span = document.getElementsByClassName("close")[0];    
$("#driverPad").on("click","div.myBtn2", function(){
    change();
 
});
$("#withDriver").on("click","div.myBtn", function(){
    change();
 
});
$("#driverPad").on('click',"div.myBtn3", function(){
    
    change();
 
});
function change(){
        $.ajax({
        type:"GET",
        url:"/availableDriver",
        success:function(data){
            $('.modal-body').html(data);
        }
    });
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
$(".modal-body").on("click", "div.setDriver", function(){

    var arrays ={} ;
    arrays[0] =$('#drivers').val();
    arrays[1]={{$vehicle->id}};
    @if(is_null($driver[0]->drId))
        arrays[2]= 0;
    @else
        arrays[2]={{$driver[0]->id}};
    @endif
        $.ajax({
            type:"GET",
            url:"/setDriver",
            data: arrays,
            success:function(data){
                $('#driverPad').html('');
                $('#driverPad').html(data);
                
            }
        });
        modal.style.display = "none";
});
</script>
@stop