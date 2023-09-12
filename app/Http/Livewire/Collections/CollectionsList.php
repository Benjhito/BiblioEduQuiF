<?php

namespace App\Http\Livewire\Collections;

use Livewire\Component;
use App\Models\Collection;
use Livewire\WithPagination;

class CollectionsList extends Component
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
        $collections = Collection::code($this->search)
            ->orWhere->name($this->search)
            ->orWhere->descrip($this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-3.4' => $this->search,
            'sort-3.4' => $this->sort,
            'direction-3.4' => $this->direction,
        ]);

        return view('livewire.collections.collections-list', compact('collections'));
    }
}
