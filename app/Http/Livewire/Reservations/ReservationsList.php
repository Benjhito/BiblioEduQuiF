<?php

namespace App\Http\Livewire\Reservations;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationsList extends Component
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
    public $sort = 'res_date';
    public $direction = 'desc';
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
        $reservations = Reservation::lastName($this->search)
            ->orWhere->memberCode($this->search)
            ->orWhere->resNumber($this->search)
            ->dateRange($this->iniDate, $this->finDate)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);
            //->get();

        session([
            'search-6.2' => $this->search,
            'memberId-6.2' => $this->memberId,
            'iniDate-6.2' => $this->iniDate,
            'finDate-6.2' => $this->finDate,
            'sort-6.2' => $this->sort,
            'direction-6.2' => $this->direction,
        ]);

        return view('livewire.reservations.reservations-list', compact('reservations'));
    }
}
