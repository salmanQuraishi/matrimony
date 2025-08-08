<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\MethodController;
use App\Models\InterestNot;

class InterestnotController extends Controller
{
    // Send a "not interest"
    public function sendnotInterest(User $receiver)
    {
        $sender = auth()->user();

        if ($sender->id === $receiver->id) {
            return MethodController::errorResponse('Cannot express not interest in yourself.', 400);
        }

        $interest = InterestNot::firstOrCreate([
            'user_id' => $sender->id,
            'not_interest_user_id' => $receiver->id,
        ]);

        return MethodController::successResponseSimple('Not interest request sent successfully.');
    }

    // Revoke a "not interest"
    public function revokeInterest($interestnot)
    {

        $interestnot = InterestNot::find(['id' => $interestnot])->first();       

        if (!$interestnot) {
            return MethodController::errorResponse('Not interest not found.', 404);
        }

        // Authorization check (optional but recommended)
        if ($interestnot->user_id !== auth()->id()) {
            return MethodController::errorResponse('Unauthorized action.', 403);
        }

        $interestnot->delete();

        return MethodController::successResponseSimple('Not interest revoked.');
    }

    // List of sent "not interests"
    public function notInterestlist()
    {
        $sent = auth()->user()->notInterests()->with('receiver')->get();
        

        $formatted = $sent->map(function ($notinterest) {
            return [
                'not_interest_id'   => $notinterest->id,
                'user_id'     => $notinterest->user_id,
                'not_interest_user_id'   => $notinterest->not_interest_user_id,
                'not_interest_data'      => MethodController::formatUserResponse($notinterest->not_interest_user_id), // fixed
            ];
        });
        // dd($formatted);

        return response()->json([
            'status'  => true,
            'message' => 'Not interests fetched successfully.',
            'data'    => $formatted
        ]);
    }
}