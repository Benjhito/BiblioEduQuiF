<?php

namespace Tests\Feature\Livewire\Publishers;

use App\Livewire\Publishers\PublishersList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PublishersListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(PublishersList::class)
            ->assertStatus(200);
    }
}
