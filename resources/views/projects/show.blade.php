@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="/projects" class="float-right btn btn-default btn-xs">Go Back</a></div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Project name: {{$project->name}}</li>
                        
                        <ul class="list-group-item">URL:
                            @foreach ($urls as $url)
                                <li class="list-group-item"><strong>{{$url->id}}:</strong><a href="{{$url->url}}">{{$url->url}}</a></li>
                                    @foreach ($url->checkstatuses as $status)
                                    <hr>
                                        <li class="list-group-item">Visibility: {{$status->reason}}</li>
                                        <li class="list-group-item">Last Checked: {{$status->updated_at->diffForHumans()}}</li>
                                    @endforeach
                                <hr>
                            @endforeach
                        </ul> 
                      </ul>
                      <hr>
                </div>
            </div>
        </div>
    </div>
@endsection