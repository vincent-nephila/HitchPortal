@extends('admin')
@section('content')

<div class="col-md-3">
<img src="{{url($pic1)}}" style="height:auto;width:100%;">
</div>
<div class="col-md-9">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <b>Name</b>: {{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}
                </td>
            </tr>
            
            <tr>
                <td>
                    <b>E-mail</b>: {{$applicant->email}}
                </td>
            </tr>
            
            <tr>
                <td>
                    <b>Address</b>: {{$profile->address}}
                    
                </td>
            </tr> 
            
            <tr>
                <td>
                    <b>Mobile</b>: {{$applicant->mobile}}
                </td>
            </tr>             
        </tbody>
    </table>
        <table class="table table-striped">
        <tbody>
            <tr>
                <td>
                    <b>License No:</b>{{$profile->licNo}}       <b style="padding-left: 20%">Exp. Date: </b>{{$profile->licExp}}
                </td>
            </tr>
            
            <tr>
                <td>
                    <b>Operator</b>: {{$operator->lastname}}, {{$operator->firstname}}
                </td>
            </tr>           
        </tbody>
    </table>
@if($applicant->acctStatus == env('DRIVER_PROCESS'))
<button class='btn btn-success' onclick="approve({{$applicant->id}})"><div id="status">Approve</div></button>
@endif
@if($applicant->acctStatus == env('STATUS_OK'))
<div id="status" class="btn btn-success btn-dis">APPROVED</div>
@endif
</div>
<div class="col-md-12">
<h3>Documents</h3>
<a class="fancybox" rel="group" href="{{url($pic2)}}"><div style="display:inline-block;text-align: center;">
<img src="{{url($pic2)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>License</b></h5>
</div></a>
<a class="fancybox" rel="group" href="{{url($pic3)}}">
<div style="display:inline-block;text-align: center;">
<img src="{{url($pic3)}}" class="img-responsive" height="100%" width="auto" style="max-height:100px;">
<h5><b>NBI</b></h5>
</div></a>
</div>
<script>
function approve(applicant){
   // document.getElementById("status").innerHTML = applicant;
    $.ajax({
        type:"GET",
        url:"/approveDriver/"+applicant,
        success:function(data){
                $('#status').html("");
                $('#status').html(data);            
        }
        
    });
    
}
</script>
@stop