<?php

namespace App\Http\Controllers;

use App\Models\Chaind;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminChaindController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.chainds.index', [
            'chainds' => Chaind::all(),
            'title' => "Chaind Dashboard"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.chainds.create', [
            'chainds' => Chaind::all(),
            'title' => "Add Chaind"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validateData = $request->validate([
            'type' => 'required',
            'name' => 'required|max:20',
            'slug' => 'required|unique:chainds',
            'rpc_link' => 'required',
            'stake_link' => 'required'
        ]);


        Chaind::create($validateData);

        return redirect('/dashboard/chainds')->with('success', 'New chaind has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chaind $chaind)
    {
        return view('dashboard.chainds.sh', [
            'chaind' => $chaind,
            'title' => $chaind->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chaind $chaind)
    {
        return view('dashboard.chainds.edit', [
            'chaind' => $chaind,
            'title' => "Edit chaind" . $chaind->name
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chaind $chaind)
    {
        $validateData = $request->validate([
            'type' => 'required',
            'name' => 'required|max:20',
            'rpc_link' => 'required',
            'stake_link' => 'required',
        ]);


        // Update the Chaind model
        $chaind->update($validateData);

        return redirect('/dashboard/chainds')->with('success', 'Chaind has been updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chaind $chaind)
    {
        if ($chaind->logo) {
            Storage::delete($chaind->logo);
        }

        if ($chaind->guide_link) {
            Storage::delete($chaind->guide_link);
        }
        Chaind::destroy($chaind->id);

        return redirect('/dashboard/chainds')->with('success', 'Chaind has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Chaind::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
