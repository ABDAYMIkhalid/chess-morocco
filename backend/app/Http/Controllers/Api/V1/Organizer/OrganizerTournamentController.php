<?php
namespace App\Http\Controllers\Api\V1\Organizer;
use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
class OrganizerTournamentController extends Controller { public function index(Request $request){return response()->json(['data'=>$request->user()->tournaments()->paginate()]);} public function store(Request $request){return app(\App\Http\Controllers\Api\V1\Tournament\TournamentController::class)->store($request);} }
