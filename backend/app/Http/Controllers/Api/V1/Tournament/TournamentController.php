<?php

namespace App\Http\Controllers\Api\V1\Tournament;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index(Request $request) { $query=Tournament::with(['city','club','venue','organizer'])->whereIn('status',['approved','ongoing','completed']); return response()->json(['data'=>$query->when($request->filled('city_id'),fn($q)=>$q->where('city_id',$request->integer('city_id')))->when($request->filled('q'),fn($q)=>$q->where('name','like','%'.$request->string('q').'%'))->latest('start_date')->paginate(min($request->integer('per_page',15),100))]); }
    public function store(Request $request) { $data=$request->validate(['name'=>'required|string|max:255','format'=>'required|in:swiss,round_robin,knockout','start_date'=>'required|date|after_or_equal:today','end_date'=>'nullable|date|after_or_equal:start_date','registration_deadline'=>'nullable|date|before_or_equal:start_date','city_id'=>'required|exists:cities,id','club_id'=>'nullable|exists:clubs,id','venue_id'=>'nullable|exists:venues,id','description'=>'nullable|string','max_players'=>'nullable|integer|min:2','entry_fee'=>'nullable|numeric|min:0']); $data['organizer_id']=$request->user()->id; $data['status']='pending'; return response()->json(['data'=>Tournament::create($data)],201); }
    public function show(Tournament $tournament) { $this->authorize('view',$tournament); return response()->json(['data'=>$tournament->load(['city','club','venue','organizer','registrations.player'])]); }
    public function update(Request $request, Tournament $tournament) { $this->authorize('update',$tournament); $data=$request->validate(['name'=>'sometimes|string|max:255','description'=>'nullable|string','format'=>'sometimes|in:swiss,round_robin,knockout','start_date'=>'sometimes|date','end_date'=>'nullable|date','registration_deadline'=>'nullable|date','max_players'=>'nullable|integer|min:2','entry_fee'=>'nullable|numeric|min:0']); $tournament->update($data); return response()->json(['data'=>$tournament->refresh()]); }
    public function destroy(Tournament $tournament) { $this->authorize('delete',$tournament); $tournament->delete(); return response()->json(['message'=>'Tournament deleted.']); }
}
