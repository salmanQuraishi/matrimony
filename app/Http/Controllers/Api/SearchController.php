<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function searchUsers(Request $request)
    {
        $search = $request->search;

        if (!$search) {
            return response()->json([
                'status' => false,
                'message' => 'Search keyword required'
            ], 400);
        }

        $users = User::where('name', 'LIKE', "%{$search}%")
            ->select('id', 'name', 'email', 'username')
            ->limit(20)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'data' => $users
        ]);
    }
}