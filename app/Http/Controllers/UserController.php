<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\UserRoles;
use App\UserStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\json;

class UserController extends Controller
{

    use AuthorizesRequests;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userService->index($request);
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
        $userToUpdate->update($validator->validated());
        return response()->json(null, 204);
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

    public function ban(User $user, $id)
    {
        $userToBan = User::findOrFail($id);
        $this->authorize('ban', $userToBan);

        if ($userToBan->status === UserStatus::BANNED) {
            $userToBan->update(['status' => UserStatus::ACTIVE]); // Change 'active' to the appropriate status
        } else {
            $userToBan->update(['status' => UserStatus::BANNED]);
        }
        return response(null, 204);
    }

    /** Search users */
    public function search(Request $request)
    {
        $input = $request->input('value');

        return $this->userService->search($input);
    }
}
