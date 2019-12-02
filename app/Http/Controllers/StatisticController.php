<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistic;
use App\Match;
use App\Tournament;
use App\User;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // "TODO, BITCH";

        $posts = Statistic::all();
        $tournaments = Tournament::all();
        $users = User::all();
        return view('statistics.index')
            ->with('posts', $posts)
            ->with('tournaments', $tournaments)
            ->with('users', $users )
            ->with('title', 'Přehled statistik');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        //neni to dokonale no
        $this->authorize('logged');

        $matches = Match::all();

        return view('statistics.create')
        ->with('matches', $matches)
        ->with('title', 'Vytvorit statistiku');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $match = Match::findOrFail($request->match_id);

        $match->statistics()->create($request->only(
            'match_id', 'vojenske_skore', 'ekonomicke_skore', 'technologicke_skore', 'socialni_skore', 'doba_preziti' 
        ));

        $statistic = Statistic::orderby('created_at', 'desc')->first();

        return redirect()->route('statistic.show', $statistic->id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Statistic::findOrFail($id);


        return view('statistics.show')
            ->with('post', $post)
            ->with('title', "Statistika");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Statistic::findOrFail($id);
        $matches = Match::all();
        
        //TODO
        //$this->authorize('edit-statistic', $post );

        return view('statistics.edit')
            ->with('post', $post )
            ->with('matches', $matches)
            ->with('title', 'upravit statistiku' );
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
        $post = Statistic::findOrFail($id);

        $post-> update( $request->all() );

        return redirect()->route('statistic.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Statistic::findOrFail($id);

        $match = $post->match;

        $this->authorize('create-statistic', $post->match );

        $post->delete();

        return redirect()->route('match.show', $match->id);
    }
}
