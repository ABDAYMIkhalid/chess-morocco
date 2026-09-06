<?php
namespace App\Services\Organizer;
use App\Models\User;
class OrganizerService { public function updateProfile(User $user,array $data){return $user->organizerProfile()->updateOrCreate([], $data);} }
