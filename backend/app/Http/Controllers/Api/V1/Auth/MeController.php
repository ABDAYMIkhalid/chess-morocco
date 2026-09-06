<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function show(Request $request) { return response()->json(['data'=>$request->user()->load(['playerProfile','organizerProfile'])]); }
    public function update(Request $request) { $user=$request->user(); $user->update($request->validate(['name'=>'sometimes|string','phone'=>'nullable|string','email'=>'sometimes|email|unique:users,email,'.$user->id,'password'=>'sometimes|string|min:8'])); return response()->json(['data'=>$user->refresh()]); }
}
