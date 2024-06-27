<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\json;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return User::paginate(10);
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
    public function update(Request $request, User $user, $id)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $id) {
            return response()->json(['errors' => 'Authorization error'], 403);
        }
        try {
            $validated = $request->validate([
                'email' => ['string', 'email', 'max:255'],
                'name' => ['string', 'max:255',]
            ]);

            User::findOrFail($id)->update($request->only('email', 'name'));
            return response($validated);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response()->json(['errors' => 'User not found'], 404);
            } else if ($th instanceof ValidationException) {
                return response()->json(['errors' => $th->errors(), 'email' => User::find($id)->email], 422);
            }
            return response()->json(['errors' => "Something's wrong"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, $id)
    {
        try {
            if (Auth::user()->role === 'user' && Auth::user()->id === $id) {
                User::findOrFail($id)->delete();
                return response()->json(null, 204);
            } else if (Auth::user()->role === 'admin') {
                User::findOrFail($id)->delete();
                return response()->json(null, 204);
            }
            return response()->json(['errors' => 'Authorization error', 403]);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response()->json(['errors' => 'User not found'], 404);
            }
            return response()->json(['errors' => "Something's wrong"], 500);
        }
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
