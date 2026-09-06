<?php
namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\Registration;
class ReportController extends Controller { public function registrations(){return response()->json(['data'=>Registration::selectRaw('status, count(*) as total')->groupBy('status')->get()]);} }
