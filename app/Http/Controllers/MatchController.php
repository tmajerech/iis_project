<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tournament;
use App\Match;
use Auth;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {/*
        $posts = Match::all();
        return view('matches.index')
            ->with('posts', $posts)
            ->with('title', 'Prehled zapasů');*/

        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tournaments = Tournament::all();

        return view('matches.create')
        ->with('tournaments', $tournaments)
        ->with('title', 'Vytvorit zapas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $tournament = Tournament::findOrFail($request->tournament_id);
        $tournament->matches()->create($request->only('tournament_id', 'vysledky', 'uroven_pavouka'));

        $match = Match::orderby('created_at', 'desc')->first();


        return redirect()->route('match.edit', $match->id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Match::findOrFail($id);

        $user = Auth::user();

        return view('matches.show')
            ->with('post', $post)
            ->with('title', "Match")
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Match::findOrFail($id);
        $tournaments = Tournament::all();

        $this->authorize('edit-match', $post->tournament );


        return view('matches.edit')
            ->with('post', $post )
            ->with('tournaments', $tournaments)
            ->with('title', 'upravit zapas' );
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
        $post = Match::findOrFail($id);

        
        if($request->user && $request->team){
            echo 'neplatny vyber ucastniku<br>';
            return;
        }


        $pivotData = [];
        //return $request;

        if($request->team){
            foreach($request->team as $team){
                $pivotData[$team] = ['vyhra' => ($request->vyhra_team == $team) ? true : false]; 
            }

            $post->ucastnici_team()->sync($pivotData);
        }else{
            $post->ucastnici_team()->sync([]); 
        }
        
        if($request->user){
            foreach($request->user as $user){
                $pivotData[$user] = ['vyhra' => ($request->vyhra_user == $user) ? true : false]; 
            }

            $post->ucastnici_user()->sync($pivotData);
        }else{
            $post->ucastnici_user()->sync([]); 
        }

        
        $post->vysledky = $request->vysledky;



        $post->save();

        return redirect()->route('match.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('edit-match', $post->tournament );
    }
}
