<?php

namespace Tests\Feature\Tournament;

use App\Models\{City,Tournament,User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_cannot_create_a_tournament(): void
    {
        $player = User::create(['name'=>'Player','email'=>'p@example.com','password'=>'password','role'=>'player']);
        $this->actingAs($player, 'sanctum')->postJson('/api/v1/tournaments', [])->assertForbidden();
    }

    public function test_organizer_can_update_only_their_tournament(): void
    {
        $owner = User::create(['name'=>'Owner','email'=>'owner@example.com','password'=>'password','role'=>'organizer']);
        $other = User::create(['name'=>'Other','email'=>'other@example.com','password'=>'password','role'=>'organizer']);
        $city = City::create(['name'=>'Rabat']);
        $tournament = Tournament::create(['organizer_id'=>$owner->id,'city_id'=>$city->id,'name'=>'Open','format'=>'swiss','status'=>'pending','start_date'=>now()->addMonth()]);
        $this->actingAs($other, 'sanctum')->putJson('/api/v1/tournaments/'.$tournament->id, ['name'=>'Changed'])->assertForbidden();
        $this->actingAs($owner, 'sanctum')->putJson('/api/v1/tournaments/'.$tournament->id, ['name'=>'Changed'])->assertOk();
    }
}