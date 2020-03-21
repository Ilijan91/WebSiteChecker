@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Change Url:<a href="/urls/{{$url->project_id}}/show" class="float-right btn btn-default btn-xs">Go Back</a></div>
                <div class="card-body">
                    {!!Form::open(['action' => ['UrlsController@update', $url->id],'method' => 'POST'])!!}
                    {{Form::bsText('url',$url->url,['placeholder' => 'Url of project'])}}

                    
                    {{Form::bsSelect('check_frequency'),$url->check_frequency}}



                    {{Form::bsText('last_checked',$url->last_checked,['placeholder' => 'last_checked'])}}
                    {{Form::hidden('project_id', $url->project_id)}}
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::bsSubmit('Submit',['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection