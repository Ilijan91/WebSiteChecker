@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change Url:<a href="/home" class="float-right btn btn-default btn-xs">Go Back</a></div>
                <div class="card-body">
                    {!!Form::open(['action' => ['UrlsController@update', $url->id],'method' => 'POST'])!!}
                    {{Form::bsText('url',$url->url,['placeholder' => 'Url of project'])}}
                    {{Form::bsText('check_frequency',$url->check_frequency,['placeholder' => 'Frequency'])}}
                    {{Form::hidden('project_id', $project->id)}}
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::bsSubmit('Submit',['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection