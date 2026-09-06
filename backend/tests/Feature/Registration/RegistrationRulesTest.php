<?php

namespace Tests\Feature\Registration;

use App\Models\{City,Tournament,User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_cannot_register_twice_or_when_tournament_is_not_approved(): void
    {
        $player = User::create(['name'=>'Player','email'=>'player@example.com','password'=>'password','role'=>'player']);
        $organizer = User::create(['name'=>'Organizer','email'=>'org@example.com','password'=>'password','role'=>'organizer']);
        $city = City::create(['name'=>'Fes']);
        $tournament = Tournament::create(['organizer_id'=>$organizer->id,'city_id'=>$city->id,'name'=>'Open','format'=>'swiss','status'=>'pending','start_date'=>now()->addMonth()]);
        $this->actingAs($player, 'sanctum')->postJson('/api/v1/tournaments/'.$tournament->id.'/registrations')->assertStatus(422);
        $tournament->update(['status'=>'approved']);
        $this->actingAs($player, 'sanctum')->postJson('/api/v1/tournaments/'.$tournament->id.'/registrations')->assertCreated();
        $this->actingAs($player, 'sanctum')->postJson('/api/v1/tournaments/'.$tournament->id.'/registrations')->assertStatus(422);
    }
}