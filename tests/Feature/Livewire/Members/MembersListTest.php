<?php

namespace Tests\Feature\Livewire\Members;

use App\Http\Livewire\Members\MembersList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class MembersListTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(MembersList::class);

        $component->assertStatus(200);
    }
}
