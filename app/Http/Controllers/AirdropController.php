<?php

namespace App\Http\Controllers;

use App\Models\Airdrop;
use Illuminate\Http\Request;
use App\Exports\UserAirdropsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;


class AirdropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $airdrop = Airdrop::where('user_id', auth()->user()->id)
            ->where('sudah_dikerjakan', false)
            ->orderByDesc('created_at')
            ->filter(request(['search']))
            ->union(
                Airdrop::where('user_id', auth()->user()->id)
                    ->where('sudah_dikerjakan', true)
                    ->orderByDesc('created_at')
                    ->filter(request(['search']))

            )
            ->paginate(7);

        $userId = auth()->user()->id;

        $airdropCount = Airdrop::where('user_id', $userId)->count();
        return view('airdrops.index', [
            'title' => 'Airdrop List and Notification',
            'airdrops' => $airdrop,
            'airdropCount' => $airdropCount
        ]);
    }

    public function exportToExcel()
    {
        // Filter airdrops yang dimiliki oleh user yang terautentikasi
        $userAirdrops = auth()->user()->airdrops;
        // Ambil airdrops yang dimiliki oleh user tersebut
        $userAirdrops = $user->airdrops;

        // Nama file yang diinginkan
        $fileName = $user->username . '_airdrops_' . now()->format('d-m-Y') . '.xls';

        // Download file Excel dengan nama yang ditentukan
        return Excel::download(new UserAirdropsExport($userAirdrops), $fileName);
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
            'frekuensi' => 'required|in:once,daily,weekly',
            // Sesuaikan dengan kolom-kolom lainnya
        ]);

        $user_id = auth()->user()->id;

        // Simpan data ke database
        Airdrop::create([
            'nama' => $request->nama,
            'link' => $request->link,
            'frekuensi' => $request->frekuensi,
            'sudah_dikerjakan' => false,
            'selesai' => false,
            'user_id' => $user_id
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
        return view('airdrops.edit', [
            'airdrop' => $airdrop,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url',
            'frekuensi' => 'required|in:once,daily,weekly',
            // Sesuaikan dengan kolom-kolom lainnya
        ]);

        $user_id = auth()->user()->id;

        // Retrieve the specific Airdrop instance by its ID
        $airdrop = Airdrop::find($id);

        // Check if the Airdrop instance is found
        if (!$airdrop) {
            return redirect('/airdrop')->with('error', 'Airdrop not found.');
        }

        // Update the specified columns of the retrieved instance
        $airdrop->update([
            'nama' => $request->nama,
            'link' => $request->link,
            'frekuensi' => $request->frekuensi,
            // Sesuaikan dengan kolom-kolom lainnya yang ingin Anda perbarui
        ]);

        // Redirect or return a response as appropriate
        return redirect('/airdrop')->with('success', 'Airdrop successfully updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airdrop $airdrop)
    {
        Airdrop::destroy($airdrop->id);

        return redirect('/airdrop')->with('success', 'Airdrop has been deleted!');
    }
}
