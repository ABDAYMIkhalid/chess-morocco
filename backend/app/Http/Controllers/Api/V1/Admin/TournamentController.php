<?php
namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
class TournamentController extends Controller { public function index(){return response()->json(['data'=>Tournament::with('organizer')->paginate()]);} public function pending(){return response()->json(['data'=>Tournament::where('status','pending')->with(['organizer','city','club','venue'])->paginate()]);} public function approve(Tournament $tournament){$tournament->update(['status'=>'approved']);return response()->json(['data'=>$tournament]);} public function reject(Tournament $tournament){$tournament->update(['status'=>'rejected']);return response()->json(['data'=>$tournament]);} public function update(Request $request,Tournament $tournament){$tournament->update($request->validate(['status'=>'required|in:pending,approved,rejected,ongoing,completed,cancelled']));return response()->json(['data'=>$tournament]);} public function destroy(Tournament $tournament){$tournament->delete();return response()->noContent();} }
