<?php

namespace Tests\Feature\Security;

use App\Models\{City,Tournament,User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityBoundaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_protected_endpoints_require_authentication(): void
    {
        $this->getJson('/api/v1/auth/me')->assertUnauthorized();
        $this->getJson('/api/v1/admin/dashboard')->assertUnauthorized();
        $this->postJson('/api/v1/tournaments', [])->assertUnauthorized();
    }

    public function test_invalid_tournament_input_returns_validation_errors(): void
    {
        $organizer = User::create(['name'=>'Organizer','email'=>'organizer@example.com','password'=>'password','role'=>'organizer']);
        $this->actingAs($organizer, 'sanctum')->postJson('/api/v1/tournaments', [
            'name' => '', 'format' => 'invalid', 'start_date' => 'not-a-date', 'city_id' => 999,
        ])->assertUnprocessable()->assertJsonValidationErrors(['name','format','start_date','city_id']);
    }

    public function test_unknown_tournament_returns_not_found(): void
    {
        $this->getJson('/api/v1/tournaments/999999')->assertNotFound();
    }

    public function test_full_and_expired_tournaments_reject_registration(): void
    {
        $playerOne = User::create(['name'=>'Player One','email'=>'one@example.com','password'=>'password','role'=>'player']);
        $playerTwo = User::create(['name'=>'Player Two','email'=>'two@example.com','password'=>'password','role'=>'player']);
        $organizer = User::create(['name'=>'Organizer','email'=>'organizer@example.com','password'=>'password','role'=>'organizer']);
        $city = City::create(['name'=>'Casablanca']);
        $full = Tournament::create(['organizer_id'=>$organizer->id,'city_id'=>$city->id,'name'=>'Full Open','format'=>'swiss','status'=>'approved','start_date'=>now()->addMonth(),'max_players'=>2]);

        $this->actingAs($playerOne, 'sanctum')->postJson('/api/v1/tournaments/'.$full->id.'/registrations')->assertCreated();
        $this->actingAs($playerTwo, 'sanctum')->postJson('/api/v1/tournaments/'.$full->id.'/registrations')->assertCreated();
        $third = User::create(['name'=>'Player Three','email'=>'three@example.com','password'=>'password','role'=>'player']);
        $this->actingAs($third, 'sanctum')->postJson('/api/v1/tournaments/'.$full->id.'/registrations')->assertUnprocessable();

        $expired = Tournament::create(['organizer_id'=>$organizer->id,'city_id'=>$city->id,'name'=>'Expired Open','format'=>'swiss','status'=>'approved','start_date'=>now()->addMonth(),'registration_deadline'=>now()->subDay()]);
        $this->actingAs($third, 'sanctum')->postJson('/api/v1/tournaments/'.$expired->id.'/registrations')->assertUnprocessable();
    }
}