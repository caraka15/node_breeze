<?php

namespace App\Http\Controllers;

use App\Models\User;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function sendNotification()
    {
        // Ambil daftar pengguna yang memiliki username Telegram
        $users = User::whereNotNull('telegram_username')
            ->whereHas('airdrops', function ($query) {
                // Filter Airdrops based on completion status
                $query->where('sudah_dikerjakan', false)
                    ->where('selesai', false);
            })
            ->get();

        $listUnchecked = $users->flatMap(function ($user) {
            return $user->airdrops->where('sudah_dikerjakan', false)->where('selesai', false)->pluck('nama');
        })->unique()->toArray();
        // Kirim notifikasi untuk setiap pengguna
        foreach ($users as $user) {
            $message = "Halo, {$user->name}! Ada airdrop yang belum kamu kerjakan. 
            ini list nya" . $listUnchecked;
            $chatId = $user->telegram_username;

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        }

        return "Notifikasi berhasil dikirim!";
    }
}
