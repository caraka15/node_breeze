<?php

namespace App\Exports;

use App\Models\Airdrop;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserAirdropsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Airdrop::where('user_id', Auth::user()->id)
            ->latest('updated_at')
            ->get()
            ->map(function ($airdrop) {
                return [
                    'ID' => $airdrop->id,
                    'Nama' => $airdrop->nama,
                    'Link' => $airdrop->link,
                    'Frekuensi' => $airdrop->frekuensi,
                    'Sudah Dikerjakan' => $airdrop->sudah_dikerjakan ? 'sudah' : 'belum',
                    'Selesai' => $airdrop->selesai ? 'selesai' : 'belum',
                    // Tambahkan kolom lain yang ingin Anda ekspor
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Link',
            'Frekuensi',
            'Sudah Dikerjakan',
            'Selesai',
            // Tambahkan kolom lain yang ingin Anda ekspor
        ];
    }
}
