<?php
namespace App\Http\Controllers\Api\V1\Organizer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class OrganizerController extends Controller { public function show(Request $request){return response()->json(['data'=>$request->user()->load('organizerProfile')]);} public function update(Request $request){$profile=$request->user()->organizerProfile()->updateOrCreate([], $request->validate(['organization_name'=>'nullable|string','bio'=>'nullable|string','website'=>'nullable|url'])); return response()->json(['data'=>$profile]);} }
