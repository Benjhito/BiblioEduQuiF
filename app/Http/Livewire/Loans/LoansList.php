<?php

namespace App\Http\Livewire\Loans;

use App\Models\Loan;
use Livewire\Component;
use Livewire\WithPagination;

class LoansList extends Component
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
    public $sort = 'loan_date';
    public $direction = 'asc';
    public $memberId = '';
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
        $loans = Loan::lastName($this->search)
            ->orWhere->memberCode($this->search)
            ->orWhere->loanNumber($this->search)
            ->dateRange($this->iniDate, $this->finDate)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        session([
            'search-5.2' => $this->search,
            'memberId-5.2' => $this->memberId,
            'iniDate-5.2' => $this->iniDate,
            'finDate-5.2' => $this->finDate,
            'sort-5.2' => $this->sort,
            'direction-5.2' => $this->direction,
        ]);

        return view('livewire.loans.loans-list', compact('loans'));
    }
}
