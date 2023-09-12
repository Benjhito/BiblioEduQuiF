<?php

namespace App\Http\Livewire\Devolutions;

use App\Models\Devolution;
use Livewire\Component;
use Livewire\WithPagination;

class DevolutionsList extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => ''],
        'memberId' => ['except' => ''],
        'iniDate' => ['except' => ''],
        'finDate' => ['except' => '']
    ];

    public $search = '';
    public $perPage = '10';
    public $sort = 'dev_date';
    public $direction = 'asc';
    public $memberId = '';
    public $bookId = '';
    public $iniDate = '';
    public $finDate = '';

    public function clear()
    {
        $this->search = '';
        $this->memberId = '';
        $this->iniDate = '';
        $this->finDate = '';
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
        $devolutions = Devolution::lastName($this->search)
            ->orWhere->memberCode($this->search)
            ->orWhere->devNumber($this->search)
            ->dateRange($this->iniDate, $this->finDate)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-7.2' => $this->search,
            'memberId-7.2' => $this->memberId,
            'iniDate-7.2' => $this->iniDate,
            'finDate-7.2' => $this->finDate,
            'sort-7.2' => $this->sort,
            'direction-7.2' => $this->direction,
        ]);

        return view('livewire.devolutions.devolutions-list', compact('devolutions'));
    }
}
