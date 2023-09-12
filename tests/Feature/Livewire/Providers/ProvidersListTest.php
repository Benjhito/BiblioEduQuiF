<?php

namespace Tests\Feature\Livewire\Providers;

use App\Livewire\Providers\ProvidersList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProvidersListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ProvidersList::class)
            ->assertStatus(200);
    }
}
