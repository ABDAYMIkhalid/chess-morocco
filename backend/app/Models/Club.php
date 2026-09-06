<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Club extends Model { protected $fillable=['name','city_id','description','contact_email','phone']; public function city(){return $this->belongsTo(City::class);} public function members(){return $this->hasMany(ClubMember::class);} }
