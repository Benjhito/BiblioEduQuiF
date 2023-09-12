<?php

namespace App\Http\Livewire\Providers;

use Livewire\Component;
use App\Models\Provider;
use Livewire\WithPagination;

class ProvidersList extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => ''],
    ];

    public $search = '';
    public $perPage = '10';
    public $sort = 'code';
    public $direction = 'asc';

    public function clear()
    {
        $this->search = '';
        $this->page = 1; //$this->paginators['page'] = 1;
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
        $providers = Provider::businessName($this->search)
            ->orWhere->email($this->search)
            ->orWhere->code($this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-2.1' => $this->search,
            'sort-2.1' => $this->sort,
            'direction-2.1' => $this->direction
        ]);

        return view('livewire.providers.providers-list', compact('providers'));
    }
}
