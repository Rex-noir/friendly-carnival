<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hamcrest\Type\IsNumeric;
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
     * Show the form for creating a new resource.
     */
    public function create()
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
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    /** Search users */
    public function search(Request $request)
    {
        $input = $request->input('value');

        if (empty($input)) {
            return collect([]);
        }

        if (is_numeric($input)) {
            $user =  User::find($input);

            return $user ? collect([$user]) : collect([]);
        }

        return  User::where('name', 'like', '%' . $input . '%')->get();
    }
}
