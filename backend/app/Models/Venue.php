<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Venue extends Model { protected $fillable=['name','address','city_id','capacity']; public function city(){return $this->belongsTo(City::class);} public function tournaments(){return $this->hasMany(Tournament::class);} }
