<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\User;

class TeamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams=Team::all();
        
        return view('teams.index')->with('teams',$teams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if(Team::latest()->where('owner_id',$request->user()->getKey())->first() == false){
            $team = Team::create([
                'name' => $request->name,
                'owner_id' => $request->user()->getKey()
            ]);
            $user=User::find($team->owner_id);
            $user->team_id=$team->id;
            $user->save();
    
            return redirect('/teams')->with('success', 'Team Saved');
        }else{
            return redirect('/teams')->with('error', auth()->user()->name . ' have allready a team');
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);

        if (auth()->user()->id != $team->owner_id) {
            abort(403);
        }

        return view('teams.edit')->with('team',$team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->name = $request->name;
        $team->save();

        return redirect('/teams')->with('success', 'Team changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        if (auth()->user()->id != $team->owner_id) {
            abort(403);
        }
        $team->delete();        
        User::where('team_id', $id)
                    ->update(['team_id' => null]);

        return redirect('/teams')->with('success', 'Team deleted');
    }
}
