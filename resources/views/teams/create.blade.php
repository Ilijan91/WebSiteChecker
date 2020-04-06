
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create your Team:
                    <span class="float-right"><a href="/projects" class="btn btn-secondary btn-sm float-right">Go back</a></span> 
                    <span class="float-none"><a href="/home" class="btn btn-secondary btn-sm float-right">Show my projects</a></span> 
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="post" action="{{route('teams.store')}}">
                        {!! csrf_field() !!}
                    
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>
                    
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection





