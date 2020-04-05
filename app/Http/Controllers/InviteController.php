<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invite;
use App\User;
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
        do {
            $token = Str::random(10);
        } 
        while (Invite::where('token', $token)->first());
        //create a new invite record
        $invite = Invite::create([
            'email' => $request->get('email'),
            'token' => $token
        ]);
        // send the email
        Mail::to($request->get('email'))->send(new InviteCreated($invite));
        return redirect()->back();
        }

    public function accept($token)
    {
        if (!$invite = Invite::where('token', $token)->first()) {
            abort(404);
        }

        // create the user 
       

        // delete the invite so it can't be used again
        $invite->delete();

        // log the user in and show them the public project

        return 'Invite accepted!';
    }

    public function decline($token)
    {
        if (!$invite = Invite::where('token', $token)->first()) {
            abort(404);
        } 
        // delete the invite so it can't be used again
        $invite->delete();
        return 'Invite declined!';
    }
















}
