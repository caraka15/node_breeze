<?php
// app/Http/Controllers/ExordeStatsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExordeStatsController extends Controller
{
    public function index()
    {
        return view('exorde-stats');
    }
}
