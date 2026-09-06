<?php
namespace App\Services\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthService { public function register(array $data): array {$user=User::create($data);return [$user,$user->createToken('api')->plainTextToken];} public function login(string $email,string $password,?string $device=null): array {$user=User::where('email',$email)->firstOrFail();abort_unless(Hash::check($password,$user->password),401);return [$user,$user->createToken($device ?: 'api')->plainTextToken];} public function logout(User $user): void {$user->currentAccessToken()?->delete();} public function logoutAllDevices(User $user): void {$user->tokens()->delete();} public function updateProfile(User $user,array $data): User {$user->update($data);return $user->refresh();} }
