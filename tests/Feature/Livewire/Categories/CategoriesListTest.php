<?php

namespace Tests\Feature\Livewire\Categories;

use App\Livewire\Categories\CategoriesList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoriesListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CategoriesList::class)
            ->assertStatus(200);
    }
}
