<?php

namespace App\Http\Controllers;

use App\Models\Clock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ClockController extends Controller
{
    /**
     * Show a clock
     */
    public function show(Request $request, Clock $clock)
    {
        return Inertia::render('Clocks/Show', ['clock' => $clock]);
    }

    /**
     * A form to create a new clock
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Clock::class)) {
            abort(403);
        }

        return Inertia::render('Clocks/Create');
    }
}
