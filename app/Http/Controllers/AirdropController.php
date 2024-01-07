<?php

namespace App\Http\Controllers;

use App\Models\Airdrop;
use Illuminate\Http\Request;

class AirdropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airdrops = Airdrop::all(); // Ambil semua data garapan airdrop
        return view('airdrops.index', [
            'title' => 'Airdrop List',
            'airdrops' => $airdrops
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url',
            'frekuensi' => 'required|in:sekali,daily,weekly',
            // Sesuaikan dengan kolom-kolom lainnya
        ]);

        // Simpan data ke database
        Airdrop::create([
            'nama' => $request->nama,
            'link' => $request->link,
            'frekuensi' => $request->frekuensi,
            'sudah_dikerjakan' => false,
            'selesai' => false,
            // Sesuaikan dengan kolom-kolom lainnya
        ]);

        // Redirect atau kembalikan respons yang sesuai
        return redirect('/airdrop')
            ->with('success', 'Airdrop berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function checkedUpdate(Request $request, $id)
    {
        $airdrop = Airdrop::findOrFail($id);

        // Lakukan update pada model
        $airdrop->update([
            // Sesuaikan dengan kolom-kolom lain yang perlu diupdate
            'sudah_dikerjakan' => true,
        ]);

        // Redirect atau kembalikan respons yang sesuai
        return redirect()->back()->with('success', 'Airdrop berhasil diupdate dan link dibuka di tab baru.');
    }

    public function show(Airdrop $airdrop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airdrop $airdrop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return ($request);
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required',
            'frekuensi' => 'required|in:sekali,daily,weekly',
            'sudah_dikerjakan' => 'boolean',
            // Sesuaikan dengan kolom-kolom lainnya
        ]);

        $airdrop = Airdrop::find($id);

        // Update data di database
        $airdrop->update([
            'nama' => $request->nama,
            'link' => $request->link,
            'frekuensi' => $request->frekuensi,
            'sudah_dikerjakan' => $request->has('sudah_dikerjakan'),
            // Sesuaikan dengan kolom-kolom lainnya
        ]);

        // Redirect atau kembalikan respons yang sesuai
        return redirect('/airdrop')->with('success', 'Airdrop berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airdrop $airdrop)
    {
        //
    }
}
