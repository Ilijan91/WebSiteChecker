<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Url;
use DB;


class UrlsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $project= Project::findOrFail($id);
        return view('urls.create')->with('project',$project);
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
            'url' => ['required','url','unique:urls']
          ]);
        
          // Create url
          $url = new Url();
          $url->url = $request->input('url');
          $url->check_frequency = $request->input('check_frequency');
          $url->last_checked = $request->input('last_checked');
          $url->project_id = $request->input('project_id');
  
          $url->save();
  
          return redirect('/home')->with('success', 'Url Added');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project= Project::find($id);
        $this->authorize('update',$project);
        $urls = DB::table('urls')->where('project_id', $project->id)->get();
        return view('urls.show',compact('urls','project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $url= Url::find($id);
        $this->authorize('update',$url);
        return view('urls.edit', compact('url'));
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
       
        $url= Url::find($id);
        $this->authorize('update',$url);
    
        $url->url = $request->input('url');
        $url->check_frequency = $request->input('check_frequency');
        $url->project_id = $request->input('project_id');;

        $url->save();

        return redirect('/home')->with('success', 'Url Changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url= Url::find($id);
        $this->authorize('update',$url);
        $url->delete();
        
        return redirect('/home')->with('success', 'Url Deleted');
        
    }
}
