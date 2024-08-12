<?php

namespace App\Http\Controllers;

use App\Events\ClockUpdated;
use App\Models\Clock;
use Illuminate\Http\Request;
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
     * Manage a clock
     */
    public function manage(Request $request, Clock $clock)
    {
        if ($request->user()->cannot('update', $clock)) {
            abort(403);
        }

        return Inertia::render('Clocks/Manage', ['clock' => $clock]);
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
            'name' => ['string', 'required', 'max: 255'],
            'month_format' => [Rule::in(['short', 'long'])],
            'weekday_format' => [Rule::in(['short', 'long', 'hide'])],
            'ampm_format' => [Rule::in(['am_pm', 'a_p', 'dot_pm', 'dot_am', 'hide'])],
            'ampm_dot_size' => ['integer', 'numeric', 'min:1'],
            'width' => ['integer', 'numeric', 'between:1, 10000'],
            'height' => ['integer', 'numeric', 'between:1, 10000'],
            'date_x' => ['integer', 'numeric', 'between:-10000, 10000'],
            'clock_x' => ['integer', 'numeric', 'between:-10000, 10000'],
            'alarm_x' => ['integer', 'numeric', 'between:-10000, 10000'],
            'date_size' => ['integer', 'numeric', 'min:1'],
            'time_size' => ['integer', 'numeric', 'min:1'],
            'alarm_size' => ['integer', 'numeric', 'min:1'],
            'date_y' => ['integer', 'numeric', 'between:-10000, 10000'],
            'clock_y' => ['integer', 'numeric', 'between:-10000, 10000'],
            'alarm_y' => ['integer', 'numeric', 'between:-10000, 10000'],
            'date_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
            'clock_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
            'alarm_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
        ]);

        $validateAttributes['show_date'] = $request->input('show_date');
        $validateAttributes['show_next_alarm'] = $request->input('show_next_alarm');
        $validateAttributes['show_seconds'] = $request->input('show_seconds');
        $validateAttributes['use_12hr'] = $request->input('use_12hr');
        $validateAttributes['show_ampm'] = $request->input('show_ampm');
        $validateAttributes['shorten_ampm'] = $request->input('shorten_ampm');

        $validateAttributes['user_id'] = $request->user()->id;

        $clock = Clock::create($validateAttributes);

        flash('Clock Created');
        return to_route('clocks.show', ['clock' => $clock]);
    }

    /**
     * Update a clock
     */
    public function update(Request $request, Clock $clock)
    {
        if ($request->user()->cannot('update', $clock)) {
            abort(403);
        }

        $validateAttributes = $request->validate([
            'name' => ['required', 'max: 255'],
            'month_format' => [Rule::in(['short', 'long'])],
            'weekday_format' => [Rule::in(['short', 'long', 'hide'])],
            'ampm_format' => [Rule::in(['am_pm', 'a_p', 'dot_pm', 'dot_am', 'hide'])],
            'ampm_dot_size' => ['integer', 'numeric', 'min:1'],
            'width' => ['integer', 'numeric', 'between:1, 10000'],
            'height' => ['integer', 'numeric', 'between:1, 10000'],
            'date_x' => ['integer', 'numeric', 'between:-10000, 10000'],
            'clock_x' => ['integer', 'numeric', 'between:-10000, 10000'],
            'alarm_x' => ['integer', 'numeric', 'between:-10000, 10000'],
            'date_y' => ['integer', 'numeric', 'between:-10000, 10000'],
            'clock_y' => ['integer', 'numeric', 'between:-10000, 10000'],
            'alarm_y' => ['integer', 'numeric', 'between:-10000, 10000'],
            'date_size' => ['integer', 'numeric', 'min:1'],
            'time_size' => ['integer', 'numeric', 'min:1'],
            'alarm_size' => ['integer', 'numeric', 'min:1'],
            'date_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
            'clock_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
            'alarm_font' => [Rule::in(['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])],
        ]);

        $validateAttributes['show_date'] = $request->input('show_date');
        $validateAttributes['show_next_alarm'] = $request->input('show_next_alarm');
        $validateAttributes['show_seconds'] = $request->input('show_seconds');
        $validateAttributes['use_12hr'] = $request->input('use_12hr');
        $validateAttributes['show_ampm'] = $request->input('show_ampm');
        $validateAttributes['shorten_ampm'] = $request->input('shorten_ampm');

        $clock->update($validateAttributes);

        broadcast(new ClockUpdated($clock));
    }

    /**
     * Destroy a clock
     */
    public function destroy(Request $request, Clock $clock) 
    {
        if ($request->user()->cannot('delete', $clock)) {
            abort(403);
        }

        $clock->alarms()->delete();
        $clock->delete();

        flash('Clock Deleted');
        return to_route('dashboard');
    }
}
