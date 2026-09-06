<?php
namespace App\Policies;
use App\Models\{User,Registration};
class RegistrationPolicy { public function viewAny(User $user,$tournament): bool{return $user->isAdmin() || ($tournament instanceof \App\Models\Tournament && $tournament->organizer_id === $user->id);} public function view(User $user,Registration $registration): bool{return $user->id===$registration->player_id || $user->isAdmin() || $user->id===$registration->tournament->organizer_id;} public function update(User $user,Registration $registration): bool{return $user->isAdmin() || $user->id===$registration->tournament->organizer_id;} public function cancel(User $user,Registration $registration): bool{return $this->view($user,$registration);} }
