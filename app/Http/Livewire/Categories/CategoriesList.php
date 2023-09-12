<?php

namespace App\Http\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoriesList extends Component
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
        $categories = Category::code($this->search)
            ->orWhere->name($this->search)
            ->orWhere->descrip($this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-3.3' => $this->search,
            'sort-3.3' => $this->sort,
            'direction-3.3' => $this->direction,
        ]);

        return view('livewire.categories.categories-list', compact('categories'));
    }
}
