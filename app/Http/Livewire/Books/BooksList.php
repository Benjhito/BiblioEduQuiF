<?php

namespace App\Http\Livewire\Books;

use App\Models\Book;
use Livewire\Component;
use App\Models\Provider;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Collection;
use Livewire\WithPagination;

class BooksList extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => ''],
        'providerId' => ['except' => ''],
        'publisherId' => ['except' => ''],
        'categoryId' => ['except' => ''],
        'collectionId' => ['except' => ''],
    ];

    public $search = '';
    public $perPage = '10';
    public $providerId = '';
    public $publisherId = '';
    public $categoryId = '';
    public $collectionId = '';
    public $sort = 'code';
    public $direction = 'asc';
    public $providers;
    public $publishers;
    public $categories;
    public $collections;

    public function mount()
    {
        $this->providers = Provider::all();
        $this->publishers = Publisher::all();
        $this->categories = Category::all();
        $this->collections = Collection::all();
    }

    public function clear()
    {
        $this->search = '';
        $this->providerId = '';
        $this->publisherId = '';
        $this->categoryId = '';
        $this->collectionId = '';
        $this->page = 1;
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            $this->direction = $this->direction == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function render()
    {
        $books = Book::code($this->search)
            ->orWhere->isbn($this->search)
            ->orWhere->title($this->search)
            ->orWhere->subtitle($this->search)
            ->orWhere->descrip($this->search)
            ->orWhere->author($this->search)
            ->provider($this->providerId)
            ->publisher($this->publisherId)
            ->category($this->categoryId)
            ->collection($this->collectionId)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-3.1' => $this->search,
            'providerId-3.1' => $this->providerId,
            'publisherId-3.1' => $this->publisherId,
            'categoryId-3.1' => $this->categoryId,
            'collectionId-3.1' => $this->collectionId,
            'sort-3.1' => $this->sort,
            'direction-3.1' => $this->direction,
        ]);

        return view('livewire.books.books-list', compact('books'));
    }
}
