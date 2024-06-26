<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Larinfo;

class DashBoardController extends Controller
{

    public function __invoke(Request $request)
    {
        if ($request->user() && $request->user()->hasRole('admin')) {

            $larinfo = Larinfo::getInfo();
            $users = User::with('role')->where('role_id', 3)->paginate(10);

            return inertia('Dashboard/AdminDashboard', [
                'systemStatus' => $larinfo,
                'users' => $users
            ]);
        }
        return inertia('Dashboard/Dashboard');
    }
}
