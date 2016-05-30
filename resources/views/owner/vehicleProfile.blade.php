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
               <button class="btn btn-default" id="myBtn2">Assign Driver</button>         
         @else
         <img src="{{url($drProfile)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;display:inline-block">
         <div style="display: inline-block">{{$driver[0]->firstname}} {{$driver[0]->lastname}} <br><button class="btn btn-default" id="myBtn">Change Driver</button></div>
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
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");
var btn2 = document.getElementById("myBtn2");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    $.ajax({
        type:"GET",
        url:"/availableDriver",
        success:function(data){
            $('.modal-body').html(data);
        }
    });
    modal.style.display = "block";
}

btn2.onclick = function() {
    alert('now');
    $.ajax({
        type:"GET",
        url:"/availableDriver",
        success:function(data){
            $('.modal-body').html(data);
        }
    });
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
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
    arrays[2]={{$driver[0]->id}};
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