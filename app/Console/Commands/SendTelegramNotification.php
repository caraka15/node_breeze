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
                $query->where('frekuensi', 'daily')
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
            ->map(function ($airdrop, $index) {
                // Mulai dari 1 (indeks + 1)
                return ($index + 1) . ". $airdrop";
            })
            ->implode(PHP_EOL);

        $message = "Hi $user->name!\nAirdrop notification goes here.\n\nUnchecked Airdrops:\n$listUnchecked";

        // Add the link to perform the task
        $message .= "\n\nTo work on these airdrops, click https://crxanode.com/airdrop";

        return $message;
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
