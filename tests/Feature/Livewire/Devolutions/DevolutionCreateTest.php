<?php

namespace Tests\Feature\Livewire\Devolutions;

use App\Http\Livewire\Devolutions\DevolutionCreate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DevolutionCreateTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(DevolutionCreate::class);

        $component->assertStatus(200);
    }
}
