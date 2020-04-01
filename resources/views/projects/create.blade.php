@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create your project:
                    <span class="float-right"><a href="/projects" class="btn btn-secondary btn-sm float-right">Go back</a></span> 
                    <span class="float-none"><a href="/home" class="btn btn-secondary btn-sm float-right">Show my projects</a></span> 
                </div>
                <div class="card-body">
                    {!!Form::open(['action' => 'ProjectsController@store','method' => 'POST'])!!}
                    {{Form::bsText('name','',['placeholder' => 'Project Name'])}}
                    {{ Form::label( 'Visible in public:') }}
                    <br>
                    {{ Form::radio('visibility','true') }} Yes
                    {{ Form::radio('visibility','false') }} No
                    {{Form::bsSubmit('Submit', ['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection