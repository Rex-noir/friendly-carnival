<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashBoardController extends Controller
{

    public function __invoke(Request $request)
    {
        if ($request->user() && $request->user()->hasRole('admin')) {
            return inertia('AdminDashboard');
        }
        return inertia('Dashboard');
    }
}
