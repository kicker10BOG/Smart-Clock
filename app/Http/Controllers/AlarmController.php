<?php

namespace App\Http\Controllers;

use App\Events\AlarmCreated;
use App\Events\AlarmDeleted;
use App\Events\AlarmDismissed;
use App\Events\AlarmSnoozed;
use App\Events\AlarmUpdated;
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
            'snooze_length' => ['integer', 'numeric', 'required', 'min: 1'],
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
        $alarm = Alarm::create($validateAttributes);
        
        broadcast(new AlarmCreated($alarm));
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
            'snooze_length' => ['integer', 'numeric', 'required', 'min: 1'],
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
        
        broadcast(new AlarmUpdated($alarm));
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
        
        broadcast(new AlarmUpdated($alarm));
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
        
        broadcast(new AlarmUpdated($alarm));
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
        $clock = $alarm->clock;
        $id = $alarm->id;
        $alarm->delete();
        
        broadcast(new AlarmDeleted($id, $clock));
        return to_route('clocks.show', ['clock' => $alarm->clock]);
    }

    /**
     * Enable a day an Alarm
     */
    public function enableDay(Request $request, Alarm $alarm, String $day)
    {
        if ($request->user()->cannot('update', $alarm)) {
            abort(403);
        }
        $day = strtolower($day);
        $alarm->{$day} = true;
        $alarm->save();
        $day = ucfirst($day);
        
        broadcast(new AlarmUpdated($alarm));
        return to_route('clocks.show', ['clock' => $alarm->clock]);
    }

    /**
     * Disable a day an Alarm
     */
    public function disableDay(Request $request, Alarm $alarm, String $day)
    {
        if ($request->user()->cannot('update', $alarm)) {
            abort(403);
        }
        $day = strtolower($day);
        $alarm->{$day} = false;
        $alarm->save();
        $day = ucfirst($day);

        broadcast(new AlarmUpdated($alarm));
        return to_route('clocks.show', ['clock' => $alarm->clock]);
    }

    /**
     * Snooze an alarm
     */
    public function snooze(Request $request, Alarm $alarm, int $count) {
        broadcast(new AlarmSnoozed($alarm, $count));
        return 'snoozed';
    }

    /**
     * Dismiss an alarm
     */
    public function dismiss(Request $request, Alarm $alarm) {
        broadcast(new AlarmDismissed($alarm));
        return 'dismissed';
    }
}
