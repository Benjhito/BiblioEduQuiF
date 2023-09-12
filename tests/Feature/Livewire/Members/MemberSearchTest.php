<?php

namespace Tests\Feature\Livewire\Members;

use App\Http\Livewire\Members\MemberSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class MemberSearchTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(MemberSearch::class);

        $component->assertStatus(200);
    }
}
