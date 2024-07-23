<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\Clock;
use Illuminate\Http\Request;

class AlarmController extends Controller
{

    /**
     * Store a new Alarm
     */
    public function store(Request $request)
    {
        $clock = Clock::find($request->input('clock_id'));
        if ($request->user()->cannot('update', $clock)) {
            abort(403);
        }
        $validateAttributes = $request->validate([
            'name' => ['string', 'required', 'max: 255'],
            'sleep_length' => ['integer', 'numeric', 'required', 'min: 1'],
        ]);

        $validateAttributes['hour'] = $request->input('time')['hour'];
        $validateAttributes['minute'] = $request->input('time')['minute'];
        $validateAttributes['enabled'] = $request->input('enabled');
        $validateAttributes['sunday'] = $request->input('sunday');
        $validateAttributes['monday'] = $request->input('monday');
        $validateAttributes['tuesday'] = $request->input('tuesday');
        $validateAttributes['wednesday'] = $request->input('wednesday');
        $validateAttributes['thursday'] = $request->input('thursday');
        $validateAttributes['friday'] = $request->input('friday');
        $validateAttributes['saturday'] = $request->input('saturday');
        $validateAttributes['clock_id'] = $clock->id;
        Alarm::create($validateAttributes);
        
        flash('Alarm Created');
        return to_route('clocks.show', ['clock' => $clock]);
    }

    /**
     * Update an Alarm
     */
    public function update(Request $request, Alarm $alarm)
    {
        if ($request->user()->cannot('update', $alarm)) {
            abort(403);
        }
        $validateAttributes = $request->validate([
            'name' => ['string', 'required', 'max: 255'],
            'sleep_length' => ['integer', 'numeric', 'required', 'min: 1'],
        ]);

        $validateAttributes['hour'] = $request->input('time')['hour'];
        $validateAttributes['minute'] = $request->input('time')['minute'];
        $validateAttributes['enabled'] = $request->input('enabled');
        $validateAttributes['sunday'] = $request->input('sunday');
        $validateAttributes['monday'] = $request->input('monday');
        $validateAttributes['tuesday'] = $request->input('tuesday');
        $validateAttributes['wednesday'] = $request->input('wednesday');
        $validateAttributes['thursday'] = $request->input('thursday');
        $validateAttributes['friday'] = $request->input('friday');
        $validateAttributes['saturday'] = $request->input('saturday');
        $alarm->update($validateAttributes);
        
        flash('Alarm Updated');
        return to_route('clocks.show', ['clock' => $alarm->clock]);
    }

    /**
     * Enable an Alarm
     */
    public function enable(Request $request, Alarm $alarm)
    {
        if ($request->user()->cannot('update', $alarm)) {
            abort(403);
        }
        $alarm->enabled = true;
        $alarm->save();
        
        flash('Alarm Enabled');
        return to_route('clocks.show', ['clock' => $alarm->clock]);
    }

    /**
     * Disable an Alarm
     */
    public function disable(Request $request, Alarm $alarm)
    {
        if ($request->user()->cannot('update', $alarm)) {
            abort(403);
        }
        $alarm->enabled = false;
        $alarm->save();
        
        flash('Alarm Disabled');
        return to_route('clocks.show', ['clock' => $alarm->clock]);
    }

    /**
     * Delete an Alarm
     */
    public function destroy(Request $request, Alarm $alarm)
    {
        if ($request->user()->cannot('delete', $alarm)) {
            abort(403);
        }
        $alarm->delete();
        
        flash('Alarm Deleted');
        return to_route('clocks.show', ['clock' => $alarm->clock]);
    }
}
