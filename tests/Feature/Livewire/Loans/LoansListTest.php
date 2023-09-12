<?php

namespace Tests\Feature\Livewire\Loans;

use App\Livewire\Loans\LoansList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LoansListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(LoansList::class)
            ->assertStatus(200);
    }
}
