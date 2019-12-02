<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = User::all();

        return view('users.index')
        ->with('title', 'Přehled uživatelů')
        ->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('logged');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::findOrFail($id);

        return view('users.show')
        ->with('user',$user);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('edit-user', $user );

        return view('users.edit')
        ->with('user', $user)
        ->with('title', "Upravit uživatele");
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
        $user = User::findOrFail($id);


        $user->jmeno = $request->jmeno;
        $user->email = $request->email;
        $user->name = $request->name;

        if($request->password != null && $request->password_confirmation != null){
            $user->password = bcrypt($request->password);
        }

        if($request->administrator){
            $user->administrator = 1;
        }else{
            $user->administrator = 0;
        }

        $user->save();


        return redirect()->route('user.show', $user->id );



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        
        $this->authorize('edit-user', $user );

        $user->delete();

        return redirect()->route('user.index');
    }
}
