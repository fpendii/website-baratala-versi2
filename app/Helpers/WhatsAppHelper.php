<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppHelper
{
    /**
     * Kirim pesan WA ke target tertentu (nomor atau group ID).
     */
    public static function send($target, $message)
    {
        $apiKey = env('FONNTE_API_KEY');

        if (!$apiKey || $apiKey === 'dummy_key') {
            Log::info("WhatsApp not sent (no API key). Target: $target, Message: $message");
            return;
        }

        return Http::withHeaders([
            'Authorization' => $apiKey,
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,  // bisa nomor WA (628xxxx) atau group ID (1203xxx@g.us)
            'message' => $message,
        ]);
    }

    /**
     * Kirim pesan WA ke grup yang disimpan di .env
     */
    public static function sendToGroup($message)
    {
        $groupId = env('FONNTE_GROUP_ID');

        if (!$groupId) {
            Log::info("WhatsApp group ID not set in .env");
            return;
        }

        return self::send($groupId, $message);
    }
}
