<?php
namespace Tests\Feature\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AuthTest extends TestCase { use RefreshDatabase; public function test_api_health_route_is_available():void{$this->get('/')->assertOk();} }
