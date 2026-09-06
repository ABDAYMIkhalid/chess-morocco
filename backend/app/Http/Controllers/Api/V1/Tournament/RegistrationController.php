<?php

namespace App\Http\Controllers\Api\V1\Tournament;

use App\Http\Controllers\Controller;
use App\Models\{Registration,Tournament};
use App\Services\Tournament\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(private readonly RegistrationService $registrationService) {}
    public function index(Tournament $tournament) { $this->authorize('viewAny',[Registration::class,$tournament]); return response()->json(['data'=>$tournament->registrations()->with('player')->paginate()]); }
    public function store(Request $request, Tournament $tournament) { $registration=$this->registrationService->register($tournament,$request->user()); return response()->json(['data'=>$registration->load('player')],201); }
    public function update(Request $request, Registration $registration) { $this->authorize('update',$registration); $registration->update($request->validate(['status'=>'required|in:confirmed,waitlisted,rejected,cancelled'])); return response()->json(['data'=>$registration]); }
    public function destroy(Registration $registration) { $this->authorize('cancel',$registration); $this->registrationService->cancel($registration); return response()->json(['message'=>'Registration cancelled.']); }
}
