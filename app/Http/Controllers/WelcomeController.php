<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Welcome to the API!']);
    }
}
