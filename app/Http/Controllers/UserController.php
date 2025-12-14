<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function checkUser($id)
    {
        // For demonstration, we will just return the user ID received
        return response()->json(['user_id' => $id]);
    }
    public function getProfile($id)
    {
        $user = User::find($id);
        if (!$user || !$user->profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }
        return response()->json($user->profile);
    }

    public function getTasks($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user->tasks);
    }
}
