<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the sprcified resource in storage
     * 
     *  @param \Illuminate\Http\Request $request
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::find($request['user_id']);
        if ($user['role'] === "admin") {
            return User::all();
        } else {
            return "You must be an administrator.";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
