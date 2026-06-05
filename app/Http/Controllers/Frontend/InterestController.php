<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class InterestController extends Controller
{
    public function index(Request $request)
    {
        $token = session('user_token');
        
        // Fetch sent interests
        $sentResponse = InternalApi::call('GET', '/api/interests/sent', [], $token);
        $sentInterests = $sentResponse['data'] ?? [];

        // Fetch received interests
        $receivedResponse = InternalApi::call('GET', '/api/interests/received', [], $token);
        $receivedInterests = $receivedResponse['data'] ?? [];

        // Fetch ignored/not-interested profiles
        $ignoredResponse = InternalApi::call('GET', '/api/interests/not/list', [], $token);
        $ignoredUsers = $ignoredResponse['data'] ?? [];

        return view('frontend.user.interests', [
            'sentInterests' => $sentInterests,
            'receivedInterests' => $receivedInterests,
            'ignoredUsers' => $ignoredUsers,
            'tab' => $request->query('tab', 'received'),
        ]);
    }

    public function send($receiverId)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', "/api/interests/send/{$receiverId}", [], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', $response['message'] ?? 'Interest request sent successfully!');
        }

        return back()->with('error', $response['message'] ?? 'Failed to send interest.');
    }

    public function accept($interestId)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', "/api/interests/accept/{$interestId}", [], $token);

        if (isset($response['status']) && $response['status']) {
            return redirect()->route('user.messages.show', ['id' => $interestId])
                ->with('success', 'Interest accepted! You can now start chatting.');
        }

        return back()->with('error', $response['message'] ?? 'Failed to accept interest.');
    }

    public function reject($interestId)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', "/api/interests/reject/{$interestId}", [], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Interest request rejected.');
        }

        return back()->with('error', $response['message'] ?? 'Failed to reject interest.');
    }

    public function revoke($interestId)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', "/api/interests/revoke/{$interestId}", [], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'Interest request revoked successfully.');
        }

        return back()->with('error', $response['message'] ?? 'Failed to revoke interest.');
    }

    // Ignore / Block user
    public function ignore($receiverId)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', "/api/interests/not/send/{$receiverId}", [], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'User added to ignored list. They will no longer appear in your matches.');
        }

        return back()->with('error', $response['message'] ?? 'Failed to ignore user.');
    }

    public function revokeIgnore($ignoredId)
    {
        $token = session('user_token');
        $response = InternalApi::call('POST', "/api/interests/not/revoke/{$ignoredId}", [], $token);

        if (isset($response['status']) && $response['status']) {
            return back()->with('success', 'User removed from ignored list.');
        }

        return back()->with('error', $response['message'] ?? 'Failed to remove user from ignored list.');
    }
}
