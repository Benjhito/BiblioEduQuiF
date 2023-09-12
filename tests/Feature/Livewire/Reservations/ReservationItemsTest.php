<?php

namespace Tests\Feature\Livewire\Reservations;

use App\Http\Livewire\Reservations\ReservationItems;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ReservationItemsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ReservationItems::class);

        $component->assertStatus(200);
    }
}
