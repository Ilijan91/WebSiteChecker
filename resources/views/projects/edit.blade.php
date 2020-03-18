@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    {!!Form::open(['action' => ['ProjectsController@update', $project->id],'method' => 'POST'])!!}
                    {{Form::bsText('name',$project->name,['placeholder' => 'Company Name'])}}
                    {{Form::bsText('visibility',$project->visibility,['placeholder' => 'visibility'])}}
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::bsSubmit('Submit',['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection