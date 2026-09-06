<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable { use HasApiTokens; protected $fillable=['name','email','password','phone','role']; protected $hidden=['password','remember_token']; protected $casts=['password'=>'hashed']; public function playerProfile(){return $this->hasOne(PlayerProfile::class);} public function organizerProfile(){return $this->hasOne(OrganizerProfile::class);} public function registrations(){return $this->hasMany(Registration::class,'player_id');} public function tournaments(){return $this->hasMany(Tournament::class,'organizer_id');} public function clubs(){return $this->belongsToMany(Club::class,'club_members','player_id','club_id')->withPivot('joined_at');} public function isAdmin():bool{return $this->role==='admin';} public function isOrganizer():bool{return $this->role==='organizer';} public function isPlayer():bool{return $this->role==='player';} }
