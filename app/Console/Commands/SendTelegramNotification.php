<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification extends Command
{
    protected $signature = 'telegram:send-notification';
    protected $description = 'Send notification to Telegram users';

    public function handle()
    {
        try {
            $users = $this->getUsersForNotification();
            $this->sendNotifications($users);
            $this->info('Telegram notifications sent successfully.');
        } catch (\Exception $exception) {
            Log::error('Telegram notification error: ' . $exception->getMessage());
            $this->error('Failed to send Telegram notifications.');
        }
    }

    private function getUsersForNotification()
    {
        return User::whereNotNull('telegram_username')
            ->whereHas('airdrops', function ($query) {
                $query->where('sudah_dikerjakan', false)
                    ->where('selesai', false);
            })
            ->get();
    }

    private function sendNotifications($users)
    {
        foreach ($users as $user) {
            $message = $this->buildNotificationMessage($user);
            $this->sendNotification($user->telegram_username, $message);
        }
    }

    private function buildNotificationMessage($user)
    {
        $listUnchecked = $user->airdrops
            ->where('sudah_dikerjakan', false)
            ->where('selesai', false)
            ->pluck('nama')
            ->unique()
            ->implode(', ');

        return "Hi $user->name! Airdrop notification goes here. Unchecked Airdrops: $listUnchecked";
    }

    private function sendNotification($chatId, $message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";

        Http::post($apiUrl, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
}
