<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ClubMember extends Model { public $timestamps=false; protected $fillable=['club_id','player_id','joined_at']; public function club(){return $this->belongsTo(Club::class);} public function player(){return $this->belongsTo(User::class,'player_id');} }
