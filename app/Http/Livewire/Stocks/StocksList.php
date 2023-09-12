<?php

namespace App\Http\Livewire\Stocks;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Provider;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Stock;

class StocksList extends Component
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
    public $perPage = '15';
    public $providerId = '';
    public $publisherId = '';
    public $categoryId = '';
    public $collectionId = '';
    public $sort = 'books.descrip';
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
        $this->page = 1; //$this->paginators['page'] = 1;
        $this->providerId = '';
        $this->publisherId = '';
        $this->categoryId = '';
        $this->collectionId = '';
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
        //\DB::enableQueryLog();
        $search = $this->search;

        $stocks = Stock::quantity()
            ->join('books', 'stocks.book_id', 'books.id')
            ->select('stocks.*')
            ->where(function ($query) use ($search) {
                $query->where('books.code', 'ilike', "%{$search}%")
                    ->orWhere('books.isbn', 'ilike', "%{$search}%")
                    ->orWhere('books.title', 'ilike', "%{$search}%")
                    ->orWhere('books.author', 'ilike', "%{$search}%")
                    ->provider($this->providerId)
                    ->publisher($this->publisherId)
                    ->category($this->categoryId)
                    ->collection($this->collectionId);
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);
        //$queries = \DB::getQueryLog();

        session([
            'search-7.1' => $this->search,
            'providerId-7.1' => $this->providerId,
            'publisherId-7.1' => $this->publisherId,
            'categoryId-7.1' => $this->categoryId,
            'collectionId-7.1' => $this->collectionId,
        ]);

        return view('livewire.stocks.stocks-list', compact('stocks'));
    }
}
