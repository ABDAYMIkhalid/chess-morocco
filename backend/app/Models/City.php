<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class City extends Model { protected $fillable=['name','region']; public function venues(){return $this->hasMany(Venue::class);} public function tournaments(){return $this->hasMany(Tournament::class);} }
