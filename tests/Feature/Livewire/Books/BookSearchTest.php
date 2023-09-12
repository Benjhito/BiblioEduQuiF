<?php

namespace Tests\Feature\Livewire\Books;

use App\Livewire\Books\BookSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BookSearchTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(BookSearch::class)
            ->assertStatus(200);
    }
}
