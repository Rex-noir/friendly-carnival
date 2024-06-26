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

            return inertia('Dashboard/AdminDashboard', [
                'systemStatus' => $larinfo,
            ]);
        }
        return inertia('Dashboard/Dashboard');
    }
}
