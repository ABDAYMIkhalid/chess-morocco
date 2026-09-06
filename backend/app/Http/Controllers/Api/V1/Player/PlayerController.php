<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request) { return response()->json(['data'=>User::where('role','player')->with('playerProfile')->paginate()]); }
    public function show(User $user) { abort_unless($user->role === 'player',404); return response()->json(['data'=>$user->load('playerProfile')]); }
    public function update(Request $request, User $user) { $user->playerProfile()->updateOrCreate([], $request->validate(['city_id'=>'nullable|integer','club_id'=>'nullable|integer','rating'=>'nullable|integer','bio'=>'nullable|string'])); return response()->json(['data'=>$user->load('playerProfile')]); }
    public function tournaments(User $user) { return response()->json(['data'=>$user->registrations()->with('tournament')->paginate()]); }
}
