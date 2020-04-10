
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Team List:
                    <span class="float-right"><a href="/teams" class="btn btn-secondary btn-sm float-right">Go back</a></span>
                </div>
                <div class="card-body">    
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>
                                    @if(auth()->user()->id == $team[0]->owner_id)
                                        @if(auth()->user()->getKey() != $user->getKey())
                                            <form style="display: inline-block;" action="{{route('members.destroy', [$team[0], $user])}}" method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        @if(auth()->user()->id == $team[0]->owner_id)
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Not responded to invite:
                    <span class="float-right"><a href="/teams" class="btn btn-secondary btn-sm float-right">Go back</a></span>
                </div>
                <div class="card-body">    
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>E-Mail</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($invites as $invite)
                            <tr>
                                <td>{{$invite->email}}</td>
                                <td>
                                    <a href="{{route('members.resend_invite', $invite)}}" class="btn btn-sm btn-default">
                                        <i class="fa fa-envelope-o"></i> Resend invite
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                    </table> 
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invite to {{$team[0]->name}}:
                    <span class="float-right"><a href="/teams" class="btn btn-secondary btn-sm float-right">Go back</a></span>
                </div>
                <div class="card-body">    
                    <form class="form-horizontal" method="post" action="{{route('members.invite', $team[0])}}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope-o"></i>Invite to Team
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection