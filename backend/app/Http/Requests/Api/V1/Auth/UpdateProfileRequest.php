<?php
namespace App\Http\Requests\Api\V1\Auth;
use Illuminate\Foundation\Http\FormRequest;
class UpdateProfileRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['name'=>'sometimes|string','email'=>'sometimes|email','phone'=>'nullable|string','password'=>'nullable|string|min:8'];} }
