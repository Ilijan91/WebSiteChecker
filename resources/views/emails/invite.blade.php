<p>Hi,</p>

<p>{{$user->name}} has invited you to access their account.</p>

<a href="{{ route('accept', $invite) }}">Click here to accept!</a> 
<a href="{{ route('decline', $invite) }}">Click here to decline invitation!</a> 
