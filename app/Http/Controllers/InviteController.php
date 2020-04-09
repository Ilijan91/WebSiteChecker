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
        $this->middleware('auth', ['except' => ['accept', 'decline']]);
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

        $userValid=User::select()->where('email',$invite->email)->first();
      
        if(!empty($userValid)){
       
            $user = User::findOrFail($userValid->id);
            $user->team_id = $invite->team_id;
            $user->save();
            $invite->delete(); 
            if(auth()->check() == true){  
                //if user is logedin in app in time when invite has been sent
                return redirect()->route('teams.index');
            }else{
                //if not login
                return redirect()->to('login');
            }
            
        }else{
            $invite->delete();
            session(['invite' => $invite]);
            return redirect()->to('register');
        }
        
       
        
    }

    public function decline($token)
    {
        if (!$invite = Invite::where('deny_token', $token)->first()) {
            abort(404);
        } 
        $userDeclined=User::find($invite->user_id);
        $declinedByUser=$invite;
        Mail::to($userDeclined->email)->send(new InviteCreated($userDeclined,$declinedByUser));

        $invite->delete();
        return "You have declined invitation";;// moze neka lepsa strana za decline
    }
















}
