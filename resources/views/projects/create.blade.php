@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    {!!Form::open(['action' => 'ProjectsController@store','method' => 'POST'])!!}
                    {{Form::bsText('name','',['placeholder' => 'Project Name'])}}
                    {{Form::bsText('visibility','',['placeholder' => 'visibility'])}}
                    {{Form::bsSubmit('Submit', ['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection