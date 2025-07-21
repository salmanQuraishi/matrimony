<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\MethodController;
use App\Models\Interest;
use App\Services\FirebaseNotificationService;

class InterestController extends Controller
{
    protected $firebaseNotificationService;

    public function __construct(FirebaseNotificationService $firebaseNotificationService)
    {
        $this->firebaseNotificationService = $firebaseNotificationService;
    }
    public function sendInterest(User $receiver)
    {
        $sender = auth()->user();

        if ($sender->id === $receiver->id) {
            return MethodController::errorResponse('Cannot express interest in yourself.', 400);
        }

        $interest = Interest::firstOrCreate([
            'sender_id' => $sender->id ?? null,
            'receiver_id' => $receiver->id ?? null,
        ]);

        $deviceToken = $sender->fcm_token ?? null;
        $title = 'Hello!';
        $body = 'You have a new interest request from ' . $sender->name . '.';

        $response = $this->firebaseNotificationService->sendNotification($deviceToken, $title, $body);

        dd($response);

        return MethodController::successResponseSimple('Interest 1 request sent successfully.');
    }

    public function acceptInterest(Interest $interest)
    {

        $status = $interest->status ?? null;
        if ($status === 'accepted') {
            return MethodController::successResponseSimple('Interest already accepted.');
        }

        $this->authorize('update', $interest);
        $interest->update(['status' => 'accepted']);

        $sender = $interest->sender;
        $receiver = $interest->receiver;

        $sender->chats()->syncWithoutDetaching([$receiver->id]);
        $receiver->chats()->syncWithoutDetaching([$sender->id]);

        return MethodController::successResponseSimple('Interest accepted and chat started.');
    }

    public function rejectInterest(Interest $interest)
    {
        $status = $interest->status ?? null;
        if ($status === 'rejected') {
            return MethodController::successResponseSimple('Interest already rejected.');
        }
        $this->authorize('update', $interest);
        $interest->update(['status' => 'rejected']);

        return MethodController::successResponseSimple('Interest rejected.');
    }

    public function sent()
    {
        $sent = auth()->user()->sentInterests()->with('receiver')->get();

        $formatted = $sent->map(function ($interest) {
            return [
                'interest_id'    => $interest->id,
                'status'         => $interest->status,
                'sender_id'      => $interest->sender_id,
                'receiver_id'    => $interest->receiver_id,

                // Receiver user info
                'receiver' => MethodController::formatUserResponse($interest->receiver_id),

            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Sent interests fetched successfully.',
            'data' => $formatted
        ]);
    }


    public function received()
    {
        $received = auth()->user()->receivedInterests()->with('sender')->get();

        $formatted = $received->map(function ($interest) {
            return [
                'interest_id'   => $interest->id,
                'status'        => $interest->status,
                'sender_id'     => $interest->sender_id,
                'receiver_id'   => $interest->receiver_id,

                // Sender user info
                'sender'   => MethodController::formatUserResponse($interest->sender_id),
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Received interests fetched successfully.',
            'data' => $formatted
        ]);
    }

}