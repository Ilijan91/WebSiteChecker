<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Url;
use DB;

class ProjectsController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects=Project::orderBy('created_at','desc')->get();
        

        return view('home',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'visibility' => 'required'
          ]);
  
          // Create project
          $project = new Project();
          $project->name = $request->input('name');
          $project->visibility = $request->input('visibility');
          $project->user_id = auth()->user()->id;
  
          $project->save();
  
          return redirect('/home')->with('success', 'Project Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $project= Project::findOrFail($id);
        $url = DB::table('urls')->where('project_id', $project->id)->value('url');
        
        return view('projects.show',compact('project','url'));
        
       
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project= Project::find($id);
        $this->authorize('update',$project);

        return view('projects.edit')->with('project', $project);
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
       

        $project= Project::find($id);
        $this->authorize('update',$project);
        
        $project->name = $request->input('name');
        $project->visibility = $request->input('visibility');
        $project->user_id = auth()->user()->id;

        $project->save();

        return redirect('/home')->with('success', 'Project Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project=Project::find($id);
    
        $project->delete();
        return redirect('/home')->with('success', 'Project Deleted');
    }
}
