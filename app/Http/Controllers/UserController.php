<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = User::all();
        return view("backoffice.user.all", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        $profils = Profil::all();
        $users = User::all();
        return view("backoffice.user.create", compact("profils", "users"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            "email" => "required",
            "nickname" => "required",
            "profil-id" => "required",
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->nickname = $request->nickname;
        $user->profil_id = $request->profil_id;
        $user->created_at = now();

        $user->save();

        return redirect()->route("users.index")->with("message", "user, $user->nom a été créée");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view("backoffice.user.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $profils = Profil::all();
        return view("backoffice.user.edit", compact("profils", "user"));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            "email" => "required",
            "nickname" => "required",
            "profil-id" => "required",
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->nickname = $request->nickname;
        $user->profil_id = $request->profil_id;
        $user->updated_at = now();

        $user->save();

        return redirect()->route("users.index")->with("message", " User  $user->nom a été modifié");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
     
        
        foreach ($user->profils as $profil) {
            $user->profil_id = Profil::where("nom", "Sans Equipe")->first()->id;
            $user->save();
        }
        $user->delete();

        return redirect()->back();
    }
}
