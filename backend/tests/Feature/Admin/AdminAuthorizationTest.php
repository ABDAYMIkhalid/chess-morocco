<?php

namespace Tests\Feature\Admin;

use App\Models\{City,Tournament,User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_cannot_access_admin_dashboard(): void
    {
        $player = User::create(['name'=>'Player','email'=>'player@example.com','password'=>'password','role'=>'player']);
        $this->actingAs($player, 'sanctum')->getJson('/api/v1/admin/dashboard')->assertForbidden();
    }

    public function test_admin_can_approve_a_pending_tournament(): void
    {
        $admin = User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>'password','role'=>'admin']);
        $organizer = User::create(['name'=>'Organizer','email'=>'organizer@example.com','password'=>'password','role'=>'organizer']);
        $city = City::create(['name'=>'Rabat']);
        $tournament = Tournament::create(['organizer_id'=>$organizer->id,'city_id'=>$city->id,'name'=>'Pending Open','format'=>'swiss','status'=>'pending','start_date'=>now()->addMonth()]);
        $this->actingAs($admin, 'sanctum')->patchJson('/api/v1/admin/tournaments/'.$tournament->id.'/approve')->assertOk()->assertJsonPath('data.status','approved');
    }
}