<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $menus = session('menus');
        return view('dashboard.index', compact('menus'));
    }
}
