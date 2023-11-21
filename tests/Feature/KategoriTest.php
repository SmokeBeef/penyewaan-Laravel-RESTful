<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateSuccess(): void
    {
        $response = $this->post('/api/kategori', [
            'nama' => 'alat berat',
        ]);

        $response->assertStatus(201)->assertJson([
            "message" => "success",
            "data" => [
                "nama" => "alat berat"
            ]
        ]);
    }

    public function testCreateFail(): void
    {
        $response = $this->post("/api/kategori", [
            "nama" => null,
        ]);
        $response->assertStatus(400)->assertJsonStructure([
            "errors",
        ]);
    }
    public function testFindAll(): void
    {
        $response = $this->testCreateSuccess();
        $response = $this->get("/api/kategori");
        $response->assertStatus(200)->assertJsonStructure([
            "data" => [
                [
                    "nama",
                    "created_at",
                    "updated_at",
                    "id",
                ]
            ]
        ]);
    }
}
