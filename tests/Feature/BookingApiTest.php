<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /** @test */
    public function a_customer_can_book_a_service_for_valid_date()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/bookings', [
            'service_id' => $service->id,
            'booking_date' => Carbon::now()->addDays(2)->toDateTimeString()
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Booking successful',
            ]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'service_id' => $service->id,
        ]);
    }


    public function booking_fails_if_date_is_in_the_past()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/bookings', [
            'service_id' => $service->id,
            'booking_date' => Carbon::now()->subDays(1)->toDateTimeString()
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['booking_date']);
    }
}
