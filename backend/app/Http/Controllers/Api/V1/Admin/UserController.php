<?php
namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller { public function index(){return response()->json(['data'=>User::paginate()]);} public function update(Request $request,User $user){$user->update($request->validate(['name'=>'sometimes|string','role'=>'sometimes|in:player,organizer,admin']));return response()->json(['data'=>$user]);} public function destroy(User $user){$user->delete();return response()->noContent();} }
