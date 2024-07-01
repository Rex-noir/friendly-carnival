<?php

namespace App\Services;

use App\Models\User;
use App\UserRoles;
use App\UserStatus;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Collection;

/**
 * Class UserService.
 */
class UserService
{

    public  function search(?string $searchTerm): Collection
    {
        if ($searchTerm === null || $searchTerm === '') {
            return collect([]);
        }

        if (is_numeric($searchTerm)) {
            $user = User::find($searchTerm);
            return $user ? collect([$user]) : collect([]);
        }

        return User::where('name', 'like', '%' . $searchTerm . '%')->get();
    }

    public function index(HttpRequest $request)
    {
        $query = User::query();
        if ($request->has('role') && in_array($request->input('role'), array_column(UserRoles::cases(), 'value'))) {
            $query->where('role', $request->input('role'));
        }
        if ($request->has('status') && in_array($request->input('status'), array_column(UserStatus::cases(), 'value'))) {
            $query->where('status', $request->input('status'));
        }
        return $query->paginate(10)->appends($request->query());
    }
}
