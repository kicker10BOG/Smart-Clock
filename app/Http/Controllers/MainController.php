<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController extends Controller
{
    public function home(Request $request) {
        // $request->session()->flash('flash.banner', 'Yay it works!');
        // $request->session()->flash('flash.bannerStyle', 'success');
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
