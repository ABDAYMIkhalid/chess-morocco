<?php
namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\Venue;
class VenueController extends Controller { public function index(){return response()->json(['data'=>Venue::paginate()]);} public function destroy(Venue $venue){$venue->delete();return response()->noContent();} }
