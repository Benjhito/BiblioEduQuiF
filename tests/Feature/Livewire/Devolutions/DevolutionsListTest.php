<?php

namespace Tests\Feature\Livewire\Devolutions;

use App\Http\Livewire\Devolutions\DevolutionsList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DevolutionsListTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(DevolutionsList::class);

        $component->assertStatus(200);
    }
}
