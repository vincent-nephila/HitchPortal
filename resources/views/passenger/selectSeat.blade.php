@extends('own')
@section('content')
<div id="vehicle">
{!!$layout!!}
{{$vehicle->veSeats}}
{{$vehicle->veMaker}}
{{$request->trip}}
<div id="test"></div>
<button class="btn btn-primary" onclick="save()">SAVE</button>
</div>
<script>
$('.seat').height($('.seat').width());
$('.driver').height($('.driver').width());

$(window).resize(function(){
    $('.seat').height($('.seat').width());
$('.driver').height($('.driver').width());
});

$("#vehicle").on("click", "div.seat", function(){
    if ($(this).hasClass("selected")){
        $(this).removeClass('selected');
    }
    else{
        $(this).addClass('selected');
    }
    
    $('#count').html($('.selected').length);
 
});

function save(){

    var arrays ={} ;
    arrays[0] = {{$request->trip}};
    arrays[1]=$('.selected').length;
        var x=2;
    $('.selected').each(function(){
       arrays[x]= this.id;
       x++;
    }); 
        $.ajax({ 
            type: "GET", 
            url: "/saveReservation", 
            data:arrays,
            success:function(data){   
                $('#test').html("");
                $('#test').html(data);
                 }
            });
}
</script>
@stop