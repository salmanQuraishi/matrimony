<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatList(Request $request)
    {
        $user = $request->user();

        $contacts = $user->chats()->select('users.id', 'users.name', 'users.dummyid', 'users.email', 'users.mobile', 'users.age')->get();

        return response()->json($contacts);
    }
}