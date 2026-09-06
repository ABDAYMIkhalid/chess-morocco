<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OrganizerProfile extends Model { protected $fillable=['user_id','organization_name','bio','website']; public function user(){return $this->belongsTo(User::class);} }
