<?php

namespace App\Http\Controllers;

use App\Models\Clock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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

    /**
     * Store a new clock
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Clock::class)) {
            abort(403);
        }

        $validateAttributes = $request->validate([
            'name' => ['required', 'max: 255'],
            'month_format' => [Rule::in(['short', 'long'])],
            'weekday_format' => [Rule::in(['short', 'long', 'hidden'])],
            'date_order' => [Rule::in([1, 2, 3])],
            'clock_order' => [Rule::in([1, 2, 3])],
            'alarm_order' => [Rule::in([1, 2, 3])],
            'date_size' => ['integer', 'numeric', 'min:1'],
            'clock_size' => ['integer', 'numeric', 'min:1'],
            'alarm_size' => ['integer', 'numeric', 'min:1'],
            'date_margin' => ['integer', 'numeric', 'between:-1000, 1000'],
            'clock_margin' => ['integer', 'numeric', 'between:-1000, 1000'],
            'alarm_margin' => ['integer', 'numeric', 'between:-1000, 1000'],
            'date_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
            'clock_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
            'alarm_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
        ]);

        $validateAttributes['show_next_alarm'] = $request->input('show_next_alarm');
        $validateAttributes['show_seconds'] = $request->input('show_seconds');
        $validateAttributes['use_12hr'] = $request->input('use_12hr');
        $validateAttributes['show_ampm'] = $request->input('show_ampm');
        $validateAttributes['shorten_ampm'] = $request->input('shorten_ampm');

        $validateAttributes['user_id'] = $request->user()->id;

        $clock = Clock::create($validateAttributes);

        return to_route('dashboard');
        // return Inertia::render('Dashboard');
    }
}
