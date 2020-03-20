@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="/home" class="float-right btn btn-default btn-xs">Go Back</a></div>

                <div class="card-body">
                    <ul class="list-group">Project {{$project->name}}
                        @foreach ($urls as $url)
                    <li class="list-group-item">{{$url->id}}. {{$url->url}} <a  class="float-right btn btn-primary btn-xs" href="/urls/{{$url->id}}/edit">Edit</a>
                        {!!Form::open(['action' => ['UrlsController@destroy', $url->id],'method' => 'POST', 'class' => 'float-right', 'onsubmit' => 'return confirm("Are you sure?")'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::bsSubmit('Delete', ['class' => 'btn-xs btn btn-danger'])}}
                        {!! Form::close() !!}
                    
                    </li>
                        @endforeach
                    </ul>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection