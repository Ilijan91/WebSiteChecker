@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard<span class="float-right"><a href="/projects/create" class="btn btn-success btn-sm">Add Project</a></span></div>

                <div class="card-body">
                    @if(count($projects))
                      <table class="table table-striped">
                        <tr>
                          <th>Project</th>
                          <th></th>
                          <th></th>
                        </tr>
                        @foreach($projects as $project)
                          <tr>
                            <td>{{$project->name}}</td>
                            <td><a class="float-right btn btn-primary btn-sm" href="/projects/{{$project->id}}/edit">Edit</a></td>
                            <td>
                              {!!Form::open(['action' => ['ProjectsController@destroy', $project->id],'method' => 'POST', 'class' => 'float-left', 'onsubmit' => 'return confirm("Are you sure?")'])!!}
                              {{Form::hidden('_method', 'DELETE')}}
                              {{Form::bsSubmit('Delete', ['class' => 'btn-sm btn btn-danger'])}}
                              {!! Form::close() !!}</td>
                          </tr>
                        @endforeach
                      </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
