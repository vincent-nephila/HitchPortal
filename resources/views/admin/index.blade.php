@extends('admin')
@section('content')
<div id="searchbody"> 
    <h3>Owner List</h3>
            <table class="table"><thead>
            <tr><th>Control Number</th><th>Name</th><th>Status</th></tr>        
            </thead>
            <tbody>
            @foreach($applicant as $applicants)                     
            <tr class="clickable-row" data-href="/admin/user/{{$applicants->id}}">
                <td>{{$applicants->id}}</td><td>{{$applicants->lastname}}, {{$applicants->firstname}} {{$applicants->middlename}}</td><td> 
                @if ($applicants->status == env('STATUS_OK'))
                    {{$result="OK"}}
                @endif
                @if ($applicants->status == env('STATUS_APPROVAL'))
                    {{$result="FOR ASSESSMENT"}}
                @endif                    
                @if ($applicants->status == env('STATUS_PROCESS'))
                    {{$result="INC. REQUIREMENT"}}
                @endif                                    
                </td>
            </tr> 
            @endforeach
            </tbody>
            </table>
                 </div>
@stop