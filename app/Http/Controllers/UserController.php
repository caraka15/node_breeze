<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::get();
        $total = $user->count();
        return view('dashboard.users.index', [
            'total' => $total,
            'users' => User::all(),
            'title' => "Users Dashboard"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
    }
}
