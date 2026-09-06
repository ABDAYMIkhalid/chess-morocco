<?php
namespace App\Http\Requests\Api\V1\Tournament;
use Illuminate\Foundation\Http\FormRequest;
class UpdateRegistrationStatusRequest extends FormRequest { public function authorize():bool{return true;} public function rules():array{return ['status'=>'required|in:pending,confirmed,waitlisted,rejected,cancelled'];} }
