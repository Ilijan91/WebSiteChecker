@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Url: 
                    <span class="float-none"><a href="/home" class="btn btn-secondary btn-sm float-right">Show my projects</a></span> 
                </div>
                <div class="card-body">
                    {!!Form::open(['action' => ['UrlsController@store', $project->id],'method' => 'POST'])!!}
                    {{Form::bsText('url','',['placeholder' => 'Url of project'])}}
                    {{Form::bsSelect('check_frequency')}}
                    {{Form::bsText('last_checked','',['placeholder' => 'Last checked'])}}
                    {{Form::hidden('project_id', $project->id)}}
                    {{Form::bsSubmit('Submit', ['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection