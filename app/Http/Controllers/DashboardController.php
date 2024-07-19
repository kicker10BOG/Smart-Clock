<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show(Request $request) {
        return Inertia::render('Dashboard', [
            'clocks' => $request->user()->clocks,
        ]);
    }
}
