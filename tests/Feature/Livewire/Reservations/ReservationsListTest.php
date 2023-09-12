<?php

namespace Tests\Feature\Livewire\Reservations;

use App\Livewire\Reservations\ReservationsList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ReservationsListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ReservationsList::class)
            ->assertStatus(200);
    }
}
