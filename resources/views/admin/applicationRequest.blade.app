@extends('admin')
@section('content')

  <div id="searchbody">   
            <table class="table table-striped"><thead>
            <tr><th>Student Number</th><th>Student Name</th><th>View</th></tr>        
            </thead>
            <tbody>
               
            @foreach($applicant as $applicants)
            <tr><td>{{$applicants->id}}</td><td>{{$applicants->lastname}}, {{$applicants->firstname}}
                    {{$applicants->extensionname}}</td><td>view</td></tr>
            @endforeach
            </tbody>
            </table>
                 </div>
  @stop