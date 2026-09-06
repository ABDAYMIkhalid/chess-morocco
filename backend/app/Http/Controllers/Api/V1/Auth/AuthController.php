<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users','password'=>'required|string|min:8','phone'=>'nullable|string|max:30','role'=>'nullable|in:player,organizer']);
        $user = DB::transaction(function () use ($data) {
            $role = $data['role'] ?? 'player';
            $user = User::create([...$data, 'role' => $role]);
            $role === 'player' ? $user->playerProfile()->create([]) : $user->organizerProfile()->create([]);
            return $user;
        });

        return response()->json(['data'=>$user->load(['playerProfile','organizerProfile']), 'token'=>$user->createToken('api')->plainTextToken, 'token_type'=>'Bearer'], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate(['email'=>'required|email','password'=>'required|string']);
        $user = User::where('email', $data['email'])->first();
        abort_unless($user && Hash::check($data['password'], $user->password), 401, 'Invalid credentials.');
        return response()->json(['data'=>$user, 'token'=>$user->createToken('api')->plainTextToken, 'token_type'=>'Bearer']);
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();
        return response()->json(['message'=>'Logged out successfully.']);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message'=>'Logged out of all devices.']);
    }
}
