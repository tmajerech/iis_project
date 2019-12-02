<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use Auth;
use Illuminate\Auth\AuthManager;

class TeamController extends Controller
{


    //prida uzivatele do teamu
    public function register_user($id){
        $user = Auth::user();
        $team = Team::findOrFail($id);

        $team->clenove()->attach($user->id);

        return redirect()->route('team.show', $team->id );
    }
    public function deregister_user($id){
        $user = Auth::user();
        $team = Team::findOrFail($id);

        $team->clenove()->detach($user->id);

        return redirect()->route('team.show', $team->id );
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return view('teams.index')
            ->with('teams',$teams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('logged');
        return view('teams.create')
            ->with('title', 'Vytvorit team');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $team = $user->vlastni_team()->create( ['nazev' => $request->nazev] );

        $user->je_v_teamu()->attach($team->id);

        $this->storeImage($team, $request);

        return redirect()->route('team.show', $team->id );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        $user = auth()->user();


        return view('teams.show')
            ->with('user', $user)
            ->with('team', $team);
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

        $this->authorize('edit-team', $team );

        return view('teams.edit')
            ->with('team', $team )
            ->with('title', 'upravit prispevek' );
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

        $team-> update( $request->all() );

        $this->storeImage($team, $request);

        return redirect()->route('team.show', $team->id);
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
        $this->authorize('edit-team', $team );

        $team->delete();

        return redirect()->route('team.index');
    }





    public function storeImage($team, $request){
        if($request->has('logo')){
            $team->update([
                'logo' => request()->logo->store('uploads', 'public')
            ]);
        }
    }

}
