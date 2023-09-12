<?php

namespace App\Http\Livewire\Publishers;

use Livewire\Component;
use App\Models\Publisher;
use Livewire\WithPagination;

class PublishersList extends Component
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
        $publishers = Publisher::name($this->search)
            ->orWhere->email($this->search)
            ->orWhere->code($this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-3.2' => $this->search,
            'sort-3.2' => $this->sort,
            'direction-3.2' => $this->direction
        ]);

        return view('livewire.publishers.publishers-list', compact('publishers'));
    }
}
