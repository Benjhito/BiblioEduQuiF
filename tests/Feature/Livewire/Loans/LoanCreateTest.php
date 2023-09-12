<?php

namespace Tests\Feature\Livewire\Loans;

use App\Livewire\Loans\LoanCreate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LoanCreateTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(LoanCreate::class)
            ->assertStatus(200);
    }
}
