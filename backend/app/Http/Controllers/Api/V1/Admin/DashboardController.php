<?php
namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\{User,Tournament,Club,Venue,Registration};
class DashboardController extends Controller { public function index(){return response()->json(['data'=>['users'=>User::count(),'tournaments'=>Tournament::count(),'pending_tournaments'=>Tournament::where('status','pending')->count(),'clubs'=>Club::count(),'venues'=>Venue::count(),'registrations'=>Registration::count()]]);} }
