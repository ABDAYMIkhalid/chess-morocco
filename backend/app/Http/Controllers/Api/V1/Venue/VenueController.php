<?php
namespace App\Http\Controllers\Api\V1\Venue;
use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
class VenueController extends Controller { public function index(){return response()->json(['data'=>Venue::with('city')->paginate()]);} public function store(Request $request){return response()->json(['data'=>Venue::create($request->validate(['name'=>'required|string','address'=>'nullable|string','city_id'=>'required|integer','capacity'=>'nullable|integer']))],201);} public function show(Venue $venue){return response()->json(['data'=>$venue->load('tournaments')]);} public function update(Request $request,Venue $venue){$venue->update($request->all());return response()->json(['data'=>$venue]);} public function destroy(Venue $venue){$venue->delete();return response()->noContent();} }
