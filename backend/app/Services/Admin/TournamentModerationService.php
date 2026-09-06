<?php
namespace App\Services\Admin;
use App\Models\Tournament;
class TournamentModerationService { public function setStatus(Tournament $tournament,string $status): Tournament{$tournament->update(['status'=>$status]);return $tournament->refresh();} }
