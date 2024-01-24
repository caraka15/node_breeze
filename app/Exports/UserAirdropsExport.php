<?php

namespace App\Exports;

use App\Models\Airdrop;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserAirdropsExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('airdrops', [
            'airdrops' => Airdrop::where('user_id', auth()->user()->id)->latest('updated_at')->get(),
        ]);
    }
}
