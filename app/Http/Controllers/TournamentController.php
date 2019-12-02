<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tournament;
use Auth;
use App\Team;
use App\User;

class TournamentController extends Controller
{


    public function register_user($id){
        
        $user = Auth::user();
        $tournament = Tournament::findOrFail($id);

        $this->authorize('enter-tournament', $tournament );

        if($tournament->registered_users->contains('id',$user->id)){
            return 'NA TENTO TURNAJ UZ JSTE PRIHLASENI';
        }

        $tournament->registered_users()->attach($user->id, ['poplatek_uhrazen' => '0', 'rozhodci' => '0']);

        return redirect()->route('tournament.show', $tournament->id );

    }

    public function register_judge($id){
        
        $user = Auth::user();
        $tournament = Tournament::findOrFail($id);

        $this->authorize('enter-tournament', $tournament );

        if($tournament->registered_users->contains('id',$user->id)){
            return 'NA TENTO TURNAJ UZ JSTE PRIHLASENI';
        }

        $tournament->registered_users()->attach($user->id, ['poplatek_uhrazen' => '0', 'rozhodci' => '1']);

        return redirect()->route('tournament.show', $tournament->id );

    }

    public function deregister_user($id){
        
        
        $user = Auth::user();
        $tournament = Tournament::findOrFail($id);

        $this->authorize('leave-tournament', $tournament );

        $tournament->registered_users()->detach($user->id);

        return redirect()->route('tournament.show', $tournament->id );

    }

    public function register_team($id){
        

        $user = Auth::user();
        $tournament = Tournament::findOrFail($id);
        $team = Team::findOrFail($_POST['team']);

        $this->authorize('enter-tournament-team', [$tournament, $team] );

        if($tournament->registered_teams->contains('id',$team->id)){
            return 'NA TENTO TURNAJ UZ JSTE PRIHLASENI';
        }

        $tournament->registered_teams()->attach($team->id, ['poplatek_uhrazen' => '0']);

        return redirect()->route('tournament.show', $tournament->id );
    }

    public function deregister_team($id, $team_id){
        
        $user = Auth::user();
        $tournament = Tournament::findOrFail($id);
        $team = Team::findOrFail($team_id);

        $tournament->registered_teams()->detach($team->id);

        $this->authorize('deregister-team', [$tournament, $team] );

        return redirect()->route('tournament.show', $tournament->id );
    }

    public function deregister_jineho_ucastnika($id, $clen_id){
        
        
        $user = Auth::user();
        $tournament = Tournament::findOrFail($id);
        $clen = User::findOrFail($clen_id);

        $this->authorize('deregister-jineho-ucastnika', [$tournament, $user] );

        $tournament->registered_users()->detach($clen->id);

        return redirect()->route('tournament.show', $tournament->id );

    }

    public function update_registered(){

        $tournament = Tournament::findOrFail($_POST['tournament_id']);


        
        if(!empty($_POST['teams'])){
            $ids = $tournament->registered_teams()->allRelatedIds();

            foreach($ids as $id){
                if(in_array($id, $_POST['teams'])){
                    $tournament->registered_teams()->updateExistingPivot($id, ['poplatek_uhrazen' => 1]);
                }else{
                    $tournament->registered_teams()->updateExistingPivot($id, ['poplatek_uhrazen' => 0]);
                }
            }
        }else{
            $ids = $tournament->registered_teams()->allRelatedIds();
            foreach($ids as $id)
                $tournament->registered_teams()->updateExistingPivot($id, ['poplatek_uhrazen' => "0"]);
        }

        if(!empty($_POST['users'])){
            $ids = $tournament->registered_users()->allRelatedIds();

            foreach($ids as $id){
                if(in_array($id, $_POST['users'])){
                    $tournament->registered_users()->updateExistingPivot($id, ['poplatek_uhrazen' => 1]);
                }else{
                    $tournament->registered_users()->updateExistingPivot($id, ['poplatek_uhrazen' => 0]);
                }
            }
        }else{
            $ids = $tournament->registered_users()->allRelatedIds();
            foreach($ids as $id)
                $tournament->registered_users()->updateExistingPivot($id, ['poplatek_uhrazen' => "0"]);
        }

        return redirect()->route('tournament.show', $tournament->id );

    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Tournament::all();
        return view('tournaments.index')
            ->with('posts', $posts)
            ->with('title', 'Prehled turnajů');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('logged' );

        return view('tournaments.create')
        ->with('title', 'Vytvorit turnaj');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Auth::user()->tournaments()->create( $request->all() );

        return redirect()->route('tournament.show', $post->id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Tournament::findOrFail($id);


        return view('tournaments.show')
            ->with('post', $post)
            ->with('title', $post->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Tournament::findOrFail($id);

        $this->authorize('edit-tournament', $post );

        return view('tournaments.edit')
            ->with('post', $post )
            ->with('title', 'upravit turnaj' );
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

        
        $post = Tournament::findOrFail($id);

        $post-> update( $request->all() );

        return redirect()->route('tournament.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Tournament::findOrFail($id);

        $this->authorize('edit-tournament', $post );

        $post->delete();

        return redirect()->route('tournament.index');
    }
}
