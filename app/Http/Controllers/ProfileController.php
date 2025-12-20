<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use Illuminate\Support\Facades\Auth;

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
        $userId = Auth::user()->id;
        $validatedData = $request->validated();
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('profileImages', 'public');
            $validatedData['image'] = $imagePath;
        }
        $validatedData['user_id'] = $userId;
        $profile = Profile::create($validatedData);
        return response()->json($profile, 201);
    }
}
