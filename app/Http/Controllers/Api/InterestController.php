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
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);

        $deviceToken = 'fBt02IFnREyjxWQVkfh3VW:APA91bFgW56drB5OoN5RDfNp13bGJPlyQGP7ls4ZY_Ts0WlJZYgcHqU72yklCyoZSOloW6-hT_DMTK8ECjoBjYPfTuLXuKf5bSOejc1Vo9ibZqpgULVjmMM';
        $title = 'Hello!';
        $body = 'This is a test notification.';
        $data = ['key' => 'value']; // optional

        $response = $this->firebaseNotificationService->sendNotification($deviceToken, $title, $body, $data);

        return MethodController::successResponseSimple('Interest request sent successfully.');
    }

    public function acceptInterest(Interest $interest)
    {

        if ($interest->status === 'accepted') {
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
        if ($interest->status === 'rejected') {
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