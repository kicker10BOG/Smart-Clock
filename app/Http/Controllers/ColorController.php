<?php

namespace App\Http\Controllers;

use App\Events\ColorEvent;
use App\Models\ClockColors;
use App\Models\Clock;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    /**
     * Store a new Color
     */
    public function store(Request $request)
    {
        $clock = Clock::find($request->input('clock_id'));
        if ($request->user()->cannot('update', $clock)) {
            abort(403);
        }
        $validateAttributes = $request->validate([
            'name' => ['string', 'required', 'max: 255'],
            'background' => ['string', 'required', 'max: 7'],
            'text' => ['string', 'required', 'max: 7'],
        ]);

        $validateAttributes['clock_id'] = $clock->id;
        $validateAttributes['hour'] = $request->input('time')['hour'];
        $validateAttributes['minute'] = $request->input('time')['minute'];
        $validateAttributes['enabled'] = $request->input('enabled');
        $defaultBG = $request->input('default_bg');
        $defaultText = $request->input('default_text');
        if ($defaultBG) {
            $validateAttributes['background'] = 'default';
        }
        if ($defaultText) {
            $validateAttributes['text'] = 'default';
        }
        $color = ClockColors::create($validateAttributes);
        
        broadcast(new ColorEvent($color, 'create'));
    }

    /**
     * Update a Color
     */
    public function update(Request $request, ClockColors $color)
    {
        if ($request->user()->cannot('update', $color)) {
            abort(403);
        }
        $validateAttributes = $request->validate([
            'name' => ['string', 'required', 'max: 255'],
            'background' => ['string', 'required', 'max: 7'],
            'text' => ['string', 'required', 'max: 7'],
        ]);

        $validateAttributes['hour'] = $request->input('time')['hour'];
        $validateAttributes['minute'] = $request->input('time')['minute'];
        $validateAttributes['enabled'] = $request->input('enabled');
        $defaultBG = $request->input('default_bg');
        $defaultText = $request->input('default_text');
        if ($defaultBG) {
            $validateAttributes['background'] = 'default';
        }
        if ($defaultText) {
            $validateAttributes['text'] = 'default';
        }
        $color->update($validateAttributes);
        
        broadcast(new ColorEvent($color, 'update'));
    }

    /**
     * Enable a Color
     */
    public function enable(Request $request, ClockColors $color)
    {
        if ($request->user()->cannot('update', $color)) {
            abort(403);
        }
        $color->enabled = true;
        $color->save();
        
        broadcast(new ColorEvent($color, 'enable'));
    }

    /**
     * Disable a Color
     */
    public function disable(Request $request, ClockColors $color)
    {
        if ($request->user()->cannot('update', $color)) {
            abort(403);
        }
        $color->enabled = false;
        $color->save();
        
        broadcast(new ColorEvent($color, 'disable'));
    }

    /**
     * Delete a Color
     */
    public function destroy(Request $request, ClockColors $color)
    {
        if ($request->user()->cannot('delete', $color)) {
            abort(403);
        }
        $clock = $color->clock;
        $id = $color->id;
        $color->delete();
        
        broadcast(new ColorEvent(null, "delete", $id, $clock->id));
    }
}
