<?php

namespace Tests\Feature\Livewire\Stocks;

use App\Livewire\Stocks\StocksList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class StocksListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(StocksList::class)
            ->assertStatus(200);
    }
}
