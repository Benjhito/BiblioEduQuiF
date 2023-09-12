<?php

namespace Tests\Feature\Livewire\Devolutions;

use App\Http\Livewire\Devolutions\DevolutionItems;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DevolutionItemsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(DevolutionItems::class);

        $component->assertStatus(200);
    }
}
