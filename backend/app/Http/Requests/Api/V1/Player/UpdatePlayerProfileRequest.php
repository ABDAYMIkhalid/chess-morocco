<?php
namespace App\Http\Requests\Api\V1\Player;
use Illuminate\Foundation\Http\FormRequest;
class UpdatePlayerProfileRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['city_id'=>'nullable|integer','club_id'=>'nullable|integer','rating'=>'nullable|integer','fide_id'=>'nullable|string','bio'=>'nullable|string'];} }
