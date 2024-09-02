<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MongoDB\Driver\Session;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
      $user = User::create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password')),
      ]);

      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
          'access_token' => $token, 'token_type' => 'Bearer',
      ]);
    }

    public function login(Request $request)
    {
//        $request->validate([
//            'email' => $request->get('email'),
//            'password' => $request->get('password'),
//        ]);

        $user = User::where('email', $request->email)->first();



        if (!$user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);

        }

        $token = $user->createToken('auth_token')->plainTextToken;
        \Illuminate\Support\Facades\Session::put('token', $token);

        dd(\Illuminate\Support\Facades\Session::get('token'));

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer',]);
}

    public function user(Request $request)
    {
        return response()->json(auth('sanctum')->user());
    }
    public function logout(Request $request)
    {
        request()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
