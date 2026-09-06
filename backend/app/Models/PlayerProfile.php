<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PlayerProfile extends Model { protected $fillable=['user_id','city_id','club_id','fide_id','rating','birth_date','bio']; public function user(){return $this->belongsTo(User::class);} public function city(){return $this->belongsTo(City::class);} public function club(){return $this->belongsTo(Club::class);} }
