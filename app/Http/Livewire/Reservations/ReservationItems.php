<?php

namespace App\Http\Livewire\Reservations;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\ReservationItem;

class ReservationItems extends Component
{
    public Reservation $reservation;
    public $reservationItems = null;
    public $show = false;

    protected $listeners = [
        'addedBook' => 'render',
    ];

    public function removeBook(ReservationItem $reservationItem)
    {
        if ($reservationItem->reservation->status != 'Pendiente') {
            $this->resetErrorBag();
            $this->addError('reservation', 'La Devolución ya fue confirmada.');
            return;
        }

        $this->emit('removedBook');

        $reservationItem->delete();
    }

    public function render()
    {
        if ($this->reservation)
            $this->reservationItems = $this->reservation->items()->get();

        return view('livewire.reservations.reservation-items');
    }
}
