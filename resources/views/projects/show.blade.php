@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="/projects" class="float-right btn btn-default btn-xs">Go Back</a></div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Project name: {{$project->name}}</li>
                        <li class="list-group-item">Visibility: {{$project->visibility}}</li>
                        <li class="list-group-item">Url: <a href="{{$url}}">{{$url}}</a></li>
                      </ul>
                      <hr>
                </div>
            </div>
        </div>
    </div>
@endsection