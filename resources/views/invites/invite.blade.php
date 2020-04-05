
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invite User:
                  <span class="float-right"><a href="/home" class="btn btn-secondary btn-sm float-right">My Projects</a></span>
                </div>
                
                <div class="card-body">
                    {!!Form::open(['action' => ['InviteController@invite'],'method' => 'POST'])!!}
                    {{Form::bsText('email','',['placeholder' => 'Invite users by email'])}}                 
                    {{Form::bsSubmit('Invite',['class'=>'btn btn-success'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection



