<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chaind;

class ChaindController extends Controller
{
    public function index()
    {
        return view('home', [
            "title" => "Home",
            "chainds" => Chaind::all()
        ]);
    }

    public function show(Chaind $chaind)
    {
        return view('chains', [
            "title" => "Home",
            "chaind" => $chaind,
        ]);
    }
}
