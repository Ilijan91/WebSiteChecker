@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Settings:
                  <span class="float-right"><a href="/home" class="btn btn-secondary btn-sm float-right">My Projects</a></span>
                </div>
                
                <div class="card-body">
                    {!!Form::open(['action' => ['HomeController@update', $user->id],'method' => 'POST'])!!}

                    {{Form::bsText('name',$user->name,['placeholder' => 'Username'])}}
                    {{Form::bsText('email',$user->email,['placeholder' => 'Email'])}}
                    {{ Form::label('notification_preference', null, ['class' => '']) }}
                    {{Form::bsCheckbox('notification_preference[]','mail')}}
                    {{Form::bsCheckbox('notification_preference[]','database')}}
                    {{Form::bsCheckbox('notification_preference[]','slack')}}
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::bsSubmit('Change',['class'=>'btn btn-primary'])}}
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection