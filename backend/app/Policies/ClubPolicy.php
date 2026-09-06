<?php
namespace App\Policies;
use App\Models\{User,Club};
class ClubPolicy { public function update(User $user,Club $club): bool{return $user->isAdmin() || $user->role->value==='organizer';} public function delete(User $user,Club $club): bool{return $user->isAdmin();} }
