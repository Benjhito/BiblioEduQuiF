<?php

namespace App\Http\Livewire\Books;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class BookSearch extends Component
{
    use WithPagination;

    protected $queryString = ['search' => ['except' => '']];
    public $search = '';
    public $stock = false;

    public function selectBook(Book $book)
    {
        $this->search = '';
        $this->emit('bookSelected', $book); //$this->dispatch('bookSelected', book: $book);
    }

    public function render()
    {
        $books = null;

        if ($this->search) {
            $books = Book::code($this->search)
                ->orWhere->isbn($this->search)
                ->orWhere->title($this->search)
                ->orWhere->author($this->search)
                ->stock($this->stock)
                ->orderBy('title')
                ->paginate(10);
        }

        return view('livewire.books.book-search', compact('books'));
    }
}
