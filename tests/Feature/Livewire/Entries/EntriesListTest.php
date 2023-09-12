<?php

namespace Tests\Feature\Livewire\Entries;

use App\Livewire\Entries\EntriesList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EntriesListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EntriesList::class)
            ->assertStatus(200);
    }
}
