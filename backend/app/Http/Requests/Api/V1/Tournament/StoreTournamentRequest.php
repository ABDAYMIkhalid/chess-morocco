<?php
namespace App\Http\Requests\Api\V1\Tournament;
use Illuminate\Foundation\Http\FormRequest;
class StoreTournamentRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['name'=>'required|string','format'=>'required|string','start_date'=>'required|date','city_id'=>'required|integer','venue_id'=>'nullable|integer','description'=>'nullable|string'];} }
