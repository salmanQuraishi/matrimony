<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseNotificationService
{
    protected $url;
    protected $serverKey;

    public function __construct()
    {
        $this->url = config('services.fcm.url');
        $this->serverKey = config('services.fcm.server_key');
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $payload = [
            'to' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => $data,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
        ])->post($this->url, $payload);

        return $response->json();
    }
}