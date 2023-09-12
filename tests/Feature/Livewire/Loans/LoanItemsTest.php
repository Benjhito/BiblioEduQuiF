<?php

namespace Tests\Feature\Livewire\Loans;

use App\Http\Livewire\Loans\LoanItems;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LoanItemsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(LoanItems::class);

        $component->assertStatus(200);
    }
}
