<?php

namespace App\Http\Livewire\Members;

use App\Models\Member;
use Livewire\Component;
use Livewire\WithPagination;

class MembersList extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => '']
    ];

    public $search = '';
    public $perPage = '10';
    public $sort = 'code';
    public $direction = 'asc';

    public function clear()
    {
        $this->search = '';
        $this->page = 1; // $this->paginators['page'] = 1;
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
        $members = Member::code($this->search)
            ->orWhere->lastName($this->search)
            ->orWhere->docNumber($this->search)
            ->orWhere->email($this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-1.1' => $this->search,
            'sort-1.1' => $this->sort,
            'direction-1.1' => $this->direction
        ]);

        return view('livewire.members.members-list', compact('members'));
    }
}
