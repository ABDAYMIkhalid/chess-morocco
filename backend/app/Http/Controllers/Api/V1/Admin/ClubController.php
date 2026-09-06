<?php
namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
class ClubController extends Controller { public function index(){return response()->json(['data'=>Club::paginate()]);} public function destroy(Club $club){$club->delete();return response()->noContent();} }
