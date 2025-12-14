<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;

class ProfileController extends Controller
{
    public function show($id)
    {
        $profile = Profile::where('user_id', $id)->first();
        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }else {
            return response()->json($profile);
        }
    }

    public function store(StoreProfileRequest $request)
    {
        $profile = Profile::create($request->validated());
        return response()->json($profile, 201);
    }
}
