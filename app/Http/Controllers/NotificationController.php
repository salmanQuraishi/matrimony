<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;

class NotificationController extends Controller
{
    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function createJwt($key, $scopes)
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

    private function getAccessToken($keyFilePath, $scopes)
    {
        $key = json_decode(file_get_contents($keyFilePath), true);
        $jwt = $this->createJwt($key, $scopes);

        dd($key);
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);
        

        if ($response->successful() && isset($response['access_token'])) {
            return $response['access_token'];
        }

        throw new Exception('Failed to obtain access token: ' . $response->body());
    }

    public function sendNotification(Request $request)
    {
        try {
            $id = $request->query('id');
            $notification = DB::table('tbl_notification')->where('nid', $id)->first();
            
            if (!$notification) {
                return redirect('notification')->with('error', 'Notification not found.');
            }
            
            $keyFilePath = storage_path('app/firebase/firebase_credentials.json');
            $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
            
            $scopes = $this->getAccessToken($keyFilePath, $scopes);

            dd($scopes);

            $data = [
                "message" => [
                    "topic" => "notification",
                    "data" => [
                        "title" => $notification->title,
                        "body" => $notification->desc,
                    ],
                ],
            ];

            $response = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://fcm.googleapis.com/v1/projects/team-snakalp/messages:send', $data);


                dd($response->json());

            if ($response->successful()) {
                return redirect()->route('notification.index')
                                ->with('success', 'Notification sent successfully.');
            } else {
                
                $errorMessage = $response->json()['message'] ?? $response->body();

                return redirect()->route('notification.index')
                                ->with('error', 'Something went wrong: ' . $errorMessage);
            }

        } catch (Exception $e) {
            return redirect()->route('notification.index')
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function create(){
        return view('notification.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'desc'   => 'required|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:show,hide',
        ]);

        if ($request->hasFile('image')) {
            $filename = 'notification/' . rand(99999, 9999999) . time() . '.' . $request->image->extension();
            $request->image->move(public_path('notification/'), $filename);
            $validated['image'] = $filename;
        }

        Notification::create($validated);

        return redirect()->route('notification.index')->with('success', 'Notification created successfully!');
    }
    public function index() {
        $notifications = Notification::orderBy('nid', 'asc')->get();
        return view('notification.index', compact('notifications'));
    }
    public function edit($id){
        $notification = Notification::where('nid',$id)->first();
        // dd($notification);
        return view('notification.edit',compact('notification'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'desc'   => 'required|string',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:show,hide',
        ]);

        $notification = Notification::findOrFail($id);

        if ($request->hasFile('image')) {
            
            if ($notification->image && file_exists(public_path($notification->image))) {
                unlink(public_path($notification->image));
            }

            $filename = 'notification/' . rand(99999, 9999999) . time() . '.' . $request->image->extension();
            $request->image->move(public_path('notification/'), $filename);
            $validated['image'] = $filename;
        }

        $notification->update($validated);

        return redirect()->route('notification.index')->with('success', 'Notification updated successfully!');
    }

}