<?php
namespace App\Services\Player;
use App\Models\User;
use Illuminate\Http\Request;
class PlayerService { public function search(Request $request){return User::where('role','player')->with('playerProfile')->paginate($request->integer('per_page',20));} public function updateProfile(User $user,array $data): User {$user->playerProfile()->updateOrCreate([], $data);return $user->load('playerProfile');} }
