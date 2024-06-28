<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\json;

class UserController extends Controller
{
    use AuthorizesRequests;
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
        $this->authorize('update', $user);
        $validator = validator()->make(
            $request->all(),
            ['email' => ['string', 'email', 'max:255'], 'name' => ['string', 'max:255']]
        );

        $userToUpdate = User::findOrFail($id);

        //validator fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'email' => $userToUpdate->email], 422);
        }
        //Update
        $userToUpdate->update($validator->validated());

        return response()->json(['message' => "User updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, $id)
    {
        $userToDelete = User::findOrFail($id);
        $this->authorize('delete', $userToDelete);
        $userToDelete->delete();
        return response()->json(null, 204);
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
