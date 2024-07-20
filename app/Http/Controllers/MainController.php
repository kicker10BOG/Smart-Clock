<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController extends Controller
{
    public function home(Request $request) {
        return Inertia::render('Home');
    }

    public function addFlash(Request $request)
    {
        $msg = $request->input('flash');
        $fMessages = session()->get('fMessages', []);
        $fMessages[] = $msg;
        session()->put('fMessages', $fMessages);
    }

    public function removeFlash(Request $request) 
    {
        $msg = $request->input('flash');
        // dd($msg);
        $fMessages = $request->session()->get('fMessages', []);
        foreach ($fMessages as $key => $flash) {
            if (is_object($flash)) {
                $flash = (array) $flash;
            }
            // dd($flash);
            if ($msg['id'] == $flash['id']) {
                unset($fMessages[$key]);
                break;
            }
        }
        session()->put('fMessages', $fMessages);
    }
}
