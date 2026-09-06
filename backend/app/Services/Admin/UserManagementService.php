<?php
namespace App\Services\Admin;
use App\Models\User;
class UserManagementService { public function delete(User $user): void{$user->delete();} public function changeRole(User $user,string $role): User{$user->update(['role'=>$role]);return $user->refresh();} }
