<?php
namespace App\Http\Controllers\Api\V1\Club;
use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
class ClubController extends Controller { public function index(){return response()->json(['data'=>Club::with('city')->paginate()]);} public function store(Request $request){return response()->json(['data'=>Club::create($request->validate(['name'=>'required|string','city_id'=>'required|integer','description'=>'nullable|string']))],201);} public function show(Club $club){return response()->json(['data'=>$club->load(['city','members.player'])]);} public function update(Request $request,Club $club){$club->update($request->validate(['name'=>'sometimes|string','description'=>'nullable|string','city_id'=>'sometimes|integer']));return response()->json(['data'=>$club]);} public function destroy(Club $club){$club->delete();return response()->noContent();} }
