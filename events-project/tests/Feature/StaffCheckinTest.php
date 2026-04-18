<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\EventStaff;
use App\Models\MagicLink;

class StaffCheckinTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\DB::table('user_types')->insertOrIgnore(['id' => 3, 'type' => 'Participante']);
    }

    public function test_magic_link_expires_and_blocks_access()
    {
        $user = User::factory()->create(['user_type_id' => 3]);
        $eventOwner = User::factory()->create(['user_type_id' => 3]);
        $event = Event::factory()->create(['user_id' => $eventOwner->id]);

        $link = MagicLink::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'token' => 'expired_token_12345',
            'expires_at' => now()->subHour()
        ]);

        $response = $this->get(route('staff.magic_login', ['token' => 'expired_token_12345']));
        $response->assertStatus(403);
    }

    public function test_prevent_idor_cross_event_access()
    {
        $staffUser = User::factory()->create(['user_type_id' => 3]);
        $owner1 = User::factory()->create(['user_type_id' => 3]);
        $event1 = Event::factory()->create(['user_id' => $owner1->id]);

        EventStaff::create([
            'event_id' => $event1->id,
            'user_id' => $staffUser->id,
            'is_active' => true
        ]);

        $this->actingAs($staffUser);

        $response = $this->get(route('staff.dashboard', ['event' => $event1->id]));
        $response->assertStatus(200);

        $owner2 = User::factory()->create(['user_type_id' => 3]);
        $event2 = Event::factory()->create(['user_id' => $owner2->id]);

        $maliciousResponse = $this->get(route('staff.dashboard', ['event' => $event2->id]));
        $maliciousResponse->assertStatus(403);
    }
}
