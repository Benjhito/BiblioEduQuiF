<?php

namespace App\Http\Livewire\Entries;

use App\Models\Entry;
use Livewire\Component;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Publisher;
use App\Models\Collection;
use Livewire\WithPagination;

class EntriesList extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => ''],
        'providerId' => ['except' => ''],
        'publisherId' => ['except' => ''],
        'categoryId' => ['except' => ''],
        'collectionId' => ['except' => ''],
        'iniDate' => ['except' => ''],
        'finDate' => ['except' => ''],
    ];

    public $search = '';
    public $perPage = '10';
    public $providerId = '';
    public $publisherId = '';
    public $categoryId = '';
    public $collectionId = '';
    public $iniDate = '';
    public $finDate = '';
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
        $this->page = 1;
        $this->providerId = '';
        $this->publisherId = '';
        $this->categoryId = '';
        $this->collectionId = '';
        $this->iniDate = '';
        $this->finDate = '';
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function render()
    {
        //\DB::enableQueryLog();

        $entries = Entry::bookCode($this->search)
            ->orWhere->isbn($this->search)
            ->orWhere->title($this->search)
            ->provider($this->providerId)
            ->publisher($this->publisherId)
            ->category($this->categoryId)
            ->collection($this->collectionId)
            ->dateRange($this->iniDate, $this->finDate)
            ->orderBy('provider_id')
            ->orderBy('rec_date', 'desc')
            ->orderBy('title')
            ->paginate($this->perPage);

        //$queries = \DB::getQueryLog();

        session([
            'search-4.2' => $this->search,
            'providerId-4.2' => $this->providerId,
            'publisherId-4.2' => $this->publisherId,
            'categoryId-4.2' => $this->categoryId,
            'collectionId-4.2' => $this->collectionId,
            'iniDate-4.2' => $this->iniDate,
            'finDate-4.2' => $this->finDate,
        ]);

        return view('livewire.entries.entries-list', compact('entries'));
    }
}
