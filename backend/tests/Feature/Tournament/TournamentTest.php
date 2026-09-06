<?php
namespace Tests\Feature\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class TournamentTest extends TestCase { use RefreshDatabase; public function test_tournament_endpoint_is_defined():void{$this->getJson('/api/v1/tournaments')->assertStatus(200);} }
