<?php
// app/Http/Controllers/ExordeStatsController.php

namespace App\Http\Controllers;

use App\Http\Controllers\MultiplierController;


use Illuminate\Http\Request;

class ExordeStatsController extends Controller
{
    public function index()
    {
        $multipliers = app(MultiplierController::class)->getMultipliers()->getData();
        dd($multipliers);
        return view('exorde-stats', compact('multipliers'));
    }
}
