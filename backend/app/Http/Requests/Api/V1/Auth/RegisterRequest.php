<?php
namespace App\Http\Requests\Api\V1\Auth;
use Illuminate\Foundation\Http\FormRequest;
class RegisterRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['name'=>'required|string','email'=>'required|email|unique:users','password'=>'required|string|min:8','role'=>'nullable|in:player,organizer'];} }
