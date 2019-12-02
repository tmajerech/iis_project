<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sponsor;
use App\Tournament;

class SponsorController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Sponsor::all();
        return view('sponsors.index')
            ->with('posts', $posts)
            ->with('title', 'Prehled sponzoru');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tournaments = Tournament::all();

        $this->authorize('edit-sponsor');

        return view('sponsors.create')
        ->with('title', 'Vytvorit sponzora')
        ->with('tournaments', $tournaments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $tournaments = Tournament::all();


        $sponsor = new Sponsor;
        $sponsor->name = $request->name;
        $sponsor->save();

        $this->storeImage($sponsor, $request);

        foreach($request->tournament as $index){
            $tmp = 'castka-'.$index;
            $sponsor->sponsoring()->attach($index, ['castka' => $request->$tmp ]);
        }
        

        return redirect()->route('sponsor.show', $sponsor->id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Sponsor::findOrFail($id);


        return view('sponsors.show')
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
        $post = Sponsor::findOrFail($id);
        $tournaments = Tournament::all();

        $this->authorize('edit-sponsor');

        

        return view('sponsors.edit')
            ->with('post', $post )
            ->with('tournaments', $tournaments)
            ->with('title', 'upravit sponzora' );
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
        $post = Sponsor::findOrFail($id);

        $tournaments = $post->sponsoring;


        $post->name = $request->name;


        
        $pivotData = [];
        foreach($request->tournament as $tournament){
            $pivotData[$tournament] = ['castka' => $request['castka-'.$tournament]]; 
        }
        $post->sponsoring()->sync($pivotData);
        
        $this->storeImage($post, $request);
        
        $post-> save();
        return redirect()->route('sponsor.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::findOrFail($id);

        $this->authorize('edit-sponsor');

        $sponsor->delete();

        return redirect()->route('sponsor.index');
    }





    public function storeImage($post, $request){
        if($request->has('logo')){
            $post->update([
                'logo' => request()->logo->store('uploads', 'public')
            ]);
        }
    }
}
