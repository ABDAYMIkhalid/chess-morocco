<?php
namespace App\Http\Controllers\Api\V1\City;
use App\Http\Controllers\Controller;
use App\Models\City;
class CityController extends Controller { public function index(){return response()->json(['data'=>City::orderBy('name')->get()]);} public function show(City $city){return response()->json(['data'=>$city->load(['venues','tournaments'])]);} }
