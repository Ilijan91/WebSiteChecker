<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Team;
use App\Invite;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $users = User::select()->where('team_id',$id)->get();
        $team=Team::select()->where('owner_id',$users[0]->id)->get();
        $invites=Invite::all();

        return view('members.list',compact('team','users','invites'));
    }

   
    public function destroy($team_id , $user_id)
    {
        $team = Team::findOrFail($team_id);
        if (auth()->user()->id != $team->owner_id) {
            abort(403);
        }
        $user = User::findOrFail($user_id);
        if ($user->getKey() === auth()->user()->getKey()) {
            abort(403);
        }
        $user->team_id= null;
        $user->save();

        return redirect(route('teams.index'));
    }

    public function resendInvite($invite_id)
    {
        $invite = Invite::findOrFail($invite_id);
        $team=Team::find($invite->team_id);
        Mail::to($invite->email)->send(new InviteCreated($invite));
   
        return redirect(route('members.show', $team));
    }


    public function invite(Request $request, $team_id)
    {

        $inviteMail = Invite::select()->where('email',$request->get('email'))->get();
     
        if(empty($inviteMail[0]) || $inviteMail[0]->email != $request->get('email')){
            $team = Team::findOrFail($team_id);
            $acceptToken = Str::random(16);
            $denyToken = Str::random(16);
       
            $invite = Invite::create([
                'email' => $request->get('email'),
                'accept_token' => $acceptToken,
                'deny_token' => $denyToken,
                'user_id'=>auth()->user()->id,
                'team_id'=>$team->id
            ]);
            // send the email
            Mail::to($request->get('email'))->send(new InviteCreated($invite));
        }else {
            return redirect()->back()->withErrors([
                'email' => 'The email address is already invited to the team.'
            ]);
        }
        return redirect(route('members.show', $team));
         
    }
}
