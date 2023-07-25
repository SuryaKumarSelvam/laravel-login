<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|max:8',
            'captcha' => 'required|captcha',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validator' => $validator->errors()
            ]);
        }
        $credentials = $request->only('email', 'password');
        $user = User::where($credentials)->first();
        if ($user != null) {
            return redirect()->route('dashboard');
        }

        return response()->json([
            "status" => 400,
            "message" => "Invalied Credentials"
        ]);
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function dashboard()
    {
        return view('layouts.dashboard');
    }
}
