<?php
namespace App\Policies;
use App\Models\{User,Tournament};
class TournamentPolicy { public function view(?User $user,Tournament $tournament): bool{return in_array($tournament->status,['approved','ongoing','completed'],true) || $user?->id === $tournament->organizer_id || $user?->isAdmin();} public function update(User $user,Tournament $tournament): bool{return $user->isOrganizer() && $user->id === $tournament->organizer_id || $user->isAdmin();} public function delete(User $user,Tournament $tournament): bool{return $this->update($user,$tournament);} }
