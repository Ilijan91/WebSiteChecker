@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if(count($projects))
                    <ul class="list-group">
                      @foreach($projects as $project)
                        <li class="list-group-item"><a href="/projects/{{$project->id}}">{{$project->name}}</a></li>
                      @endforeach
                    </ul>
                @else
                  <p>No Projects Found</p>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection