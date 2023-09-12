<?php

namespace Tests\Feature\Livewire\Books;

use App\Livewire\Books\BooksList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BooksListTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(BooksList::class)
            ->assertStatus(200);
    }
}
