<?php

namespace Tests\Feature\Livewire\Entries;

use App\Livewire\Entries\EntryCreate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EntryCreateTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EntryCreate::class)
            ->assertStatus(200);
    }
}
