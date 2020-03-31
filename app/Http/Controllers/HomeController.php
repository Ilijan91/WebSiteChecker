<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id= auth()->user()->id;
        $user=User::findOrFail($user_id);
        $projects=$user->projects;

        return view('projects.index',compact('projects'));
    }
    public function editSettings()
    {
        $user_id= auth()->user()->id;
        $user=User::findOrFail($user_id);

        return view('users.settings')->with('user',$user);
    }
    


    public function update(Request $request, $id)
    {
        $user_id= auth()->user()->id;
        $user= User::findOrFail($user_id);
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->notification_preference = implode(",", $request->input('notification_preference'));
       
        $user->save();
        
        return redirect('/home')->with('success', 'Settings Changed');
    }
}
