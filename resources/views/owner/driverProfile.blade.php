@extends('own')
@section('content')

<div style="padding-top:20px">
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
        </tbody>
    </table>
@if($applicant->status == env('STATUS_OK'))
<div id="status" class="btn btn-success btn-dis">APPROVED</div>
@endif
</div>
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
<div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                @if($applicant->status == 0)
                            <a href="{{url('portal/owner/driver/'.$applicant->id.'/edit')}}" class="btn btn-primary">  Edit  </a>
                            @endif
                            <a href="{{url('portal/owner/driver/')}}" class="btn btn-primary">  OK  </a>
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