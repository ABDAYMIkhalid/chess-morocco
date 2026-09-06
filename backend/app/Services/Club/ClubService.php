<?php
namespace App\Services\Club;
use App\Models\Club;
class ClubService { public function create(array $data): Club{return Club::create($data);} public function update(Club $club,array $data): Club{$club->update($data);return $club->refresh();} }
