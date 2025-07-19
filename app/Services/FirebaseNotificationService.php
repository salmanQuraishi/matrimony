<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class FirebaseNotificationService
{
    public function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function createJwt($key, $scopes)
    {
        $now = time();
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'iss' => $key['client_email'],
            'scope' => implode(' ', $scopes),
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));

        $signatureInput = $headerEncoded . '.' . $payloadEncoded;

        openssl_sign($signatureInput, $signature, $key['private_key'], 'sha256');
        $signatureEncoded = $this->base64UrlEncode($signature);

        return $signatureInput . '.' . $signatureEncoded;
    }

    public function getAccessToken($keyFilePath, $scopes)
    {
        $key = json_decode(file_get_contents($keyFilePath), true);
        $jwt = $this->createJwt($key, $scopes);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if ($response->successful() && isset($response['access_token'])) {
            return $response['access_token'];
        }

        throw new Exception('Failed to obtain access token: ' . $response->body());
    }

    public function sendNotification(String $fcmToken, String $title, String $body)
    {
        try {
            $keyFilePath = storage_path('app/firebase/firebase_credentials.json');
            $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

            $scopes = $this->getAccessToken($keyFilePath, $scopes);


            $data = [
                "message" => [
                    // "topic"=>"your_topic_name",
                    "token" => $fcmToken,
                    "data" => [
                        "title" => $title,
                        "body" => $body,
                    ],
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                    ]
                ],
            ];

            $response = Http::withToken($scopes)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://fcm.googleapis.com/v1/projects/matrimonial-webtis/messages:send', $data);


            if ($response->successful()) {
                return ['status' => true, 'message'=>'Notification Send'];
            } else {
                return ['status' => false, 'message'=>'something went wrong'];
            }

        } catch (Exception $e) {
           return ['status' => false, 'message'=>'something went wrong'. $e->getMessage()];
        }

    }

}