<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Registration extends Model { protected $fillable=['tournament_id','player_id','status','registered_at','notes']; protected $casts=['registered_at'=>'datetime']; public function tournament(){return $this->belongsTo(Tournament::class);} public function player(){return $this->belongsTo(User::class,'player_id');} }
