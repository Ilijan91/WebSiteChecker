<p>Hi,</p>

<p>{{$user->name}} has invited you to join {{$team->name}} team.</p>

<a href="{{ route('accept', $invite->accept_token) }}">Click here to accept!</a> 
<a href="{{ route('decline', $invite->deny_token) }}">Click here to decline invitation!</a> 
