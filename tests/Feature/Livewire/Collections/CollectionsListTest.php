<?php

namespace Tests\Feature\Livewire\Collections;

use App\Livewire\Collections\CollectionsList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CollectionsListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CollectionsList::class)
            ->assertStatus(200);
    }
}
