<?php
namespace App\Services\Tournament;
use App\Models\{Tournament,User};
class TournamentService { public function create(User $organizer,array $data): Tournament {$data['organizer_id']=$organizer->id;return Tournament::create($data);} public function update(Tournament $tournament,array $data): Tournament {$tournament->update($data);return $tournament->refresh();} public function delete(Tournament $tournament): void {$tournament->delete();} }
