<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invite;
use App\User;
use App\Team;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;



class InviteController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function invite()
    {
        return view('invites.invite');
    }

    public function process(Request $request)
    {
        $team=Team::select()->where('owner_id',auth()->user()->id)->get();
        $acceptToken = Str::random(16);
        $denyToken = Str::random(16);

        $invite = Invite::create([
            'email' => $request->get('email'),
            'accept_token' => $acceptToken,
            'deny_token' => $denyToken,
            'user_id'=>auth()->user()->id,
            'team_id'=>$team[0]->id
        ]);
        
        // send the email
        Mail::to($request->get('email'))->send(new InviteCreated($invite));
        return redirect()->back();
        }

    public function accept($token)
    {
        if (!$invite = Invite::where('accept_token', $token)->first()) {
            abort(404);
        }

        // create the user 
       

        // delete the invite so it can't be used again
        $invite->delete();

        // log the user in and show them the public project

        

        return "invite accepted";
        
    }

    public function decline($token)
    {
        if (!$invite = Invite::where('deny_token', $token)->first()) {
            abort(404);
        } 
        // delete the invite so it can't be used again
        $invite->delete();
        return 'Invite declined!';
    }
















}
