<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['message' => 'User registered successfully' ,'token'=> $token], 201);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Debugging: Check if credentials are received correctly
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return response()->json(['message' => 'Email and password are required'], 400);
        }

        // Debugging: Check if user exists
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Debugging: Check if password matches
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token,$user], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }


}
