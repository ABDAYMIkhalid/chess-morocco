<?php
namespace App\Services\Search;
use App\Models\Tournament;
use Illuminate\Http\Request;
class TournamentSearchService { public function search(Request $request){return Tournament::query()->when($request->q,fn($q,$v)=>$q->where('name','like','%'.$v.'%'))->when($request->city_id,fn($q,$v)=>$q->where('city_id',$v))->paginate();} }
