<?php

namespace Tests\Feature\Livewire\Reservations;

use App\Livewire\Reservations\ReservationCreate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ReservationCreateTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ReservationCreate::class)
            ->assertStatus(200);
    }
}
