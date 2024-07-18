<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MainController extends Controller
{
    public function create() {
        return Inertia::render('Register');
    }
}
