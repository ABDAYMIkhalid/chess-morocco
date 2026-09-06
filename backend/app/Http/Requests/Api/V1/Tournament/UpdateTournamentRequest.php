<?php
namespace App\Http\Requests\Api\V1\Tournament;
class UpdateTournamentRequest extends StoreTournamentRequest { public function rules():array{return array_map(fn($rule)=>str_replace('required','sometimes',$rule), parent::rules());} }
