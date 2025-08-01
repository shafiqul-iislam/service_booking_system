<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */

    public function admin_can_create_a_service()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        // Acting as admin with Sanctum
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/services', [
            'name' => 'Test Service',
            'description' => 'This is a test service',
            'price' => 1000,
            'status' => 1
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Service created successfully',
                'service' => [
                    'name' => 'Test Service',
                    'price' => 1000
                ]
            ]);

        $this->assertDatabaseHas('services', [
            'name' => 'Test Service'
        ]);
    }


    public function non_admin_cannot_create_service()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/services', [
            'name' => 'Unauthorized Service',
            'description' => 'Not allowed',
            'price' => 200,
            'status' => 1
        ]);

        $response->assertStatus(403);
    }
}
