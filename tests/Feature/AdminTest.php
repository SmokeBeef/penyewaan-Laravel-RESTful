<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSuccessCreateAdmin(): void
    {
        $this->post('/api/admin', [
            "username" => "smokebeef",
            "password" => "123"
        ])->assertJson([
            "message" => "success"
        ])->assertStatus(201);
    }
    public function testSuccessLoginAdmin(): void
    {
        $this->testSuccessCreateAdmin();
        $response = $this->post('/api/admin/login', [
            "username" => "smokebeef",
            "password" => "123"
        ]);
        $response->assertJsonStructure([
            "access_token",
            "token_type", 
            "expires_in",
            
        ])->assertStatus(200);
    }
}
