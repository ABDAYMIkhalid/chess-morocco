<?php
namespace App\Http\Controllers\Api\V1\Club;
use App\Http\Controllers\Controller;
use App\Models\{Club,ClubMember};
use Illuminate\Http\Request;
class ClubMemberController extends Controller { public function index(Club $club){return response()->json(['data'=>$club->members()->with('player')->paginate()]);} public function store(Request $request,Club $club){$member=ClubMember::create(['club_id'=>$club->id,'player_id'=>$request->validate(['player_id'=>'required|integer'])['player_id'],'joined_at'=>now()]);return response()->json(['data'=>$member],201);} public function destroy(Club $club,ClubMember $member){$member->delete();return response()->noContent();} }
