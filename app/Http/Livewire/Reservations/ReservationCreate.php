<?php

namespace App\Http\Livewire\Reservations;

use App\Models\Book;
use App\Models\Member;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\ReservationItem;

class ReservationCreate extends Component
{
    public Member $member;
    public Book $book;
    public Reservation $reservation;
    public ReservationItem $reservationItem;
    public $code, $title;

    protected $listeners = [
        'memberSelected' => 'selectMember',
        'bookSelected' => 'selectBook',
        'removedBook' => 'removeBook',
    ];

    protected $rules = [
        'code' => 'required',
        'title' => 'required',
    ];

    protected $messages = [
        'code.required' => 'Seleccione un Libro',
        'title.required' => 'Seleccione un Libro',
    ];

    public function mount()
    {
        $this->reservationItem = new ReservationItem();
    }

    public function selectMember(Member $member)
    {
        $reservation = Reservation::memberId($member->id)->resDate(now())->status('Pendiente')->first();

        if (!$reservation) {
            $lastReservation = Reservation::orderBy('res_number', 'desc')->first();
            $resNumber = $lastReservation ? (string)(((int)$lastReservation->res_number) + 1) : '1000';

            $reservation = Reservation::create([
                'res_date' => now(),
                'res_number' => $resNumber,
                'member_id' => $member->id,
                'status' => 'Pendiente'
            ]);
        }

        $this->member = $member;
        $this->reservation = $reservation;
    }

    public function selectBook(Book $book)
    {
        $this->resetErrorBag();

        $this->reservationItem->fill([
            'reservation_id' => $this->reservation->id,
            'book_id' => $book->id,
        ]);

        $this->book = $book;
        $this->code = $book->code;
        $this->title = $book->title;
    }

    public function addBook()
    {
        $this->resetErrorBag();

        if ($this->reservation->status != 'Pendiente') {
            $this->addError('reservation', 'La Reserva ya fue confirmada.');
            return;
        }

        $existingItem = $this->reservation->items()
            ->where('book_id', $this->book->id)
            ->first();

        if ($existingItem) {
            $this->addError('book', 'El libro ya está en la Reserva.');
            return;
        }

        $this->reservationItem->reservation_id = $this->reservation->id;
        $this->reservationItem->book_id = $this->book->id;
        $this->reservationItem->save();

        $this->reservation->save($this->validate());

        $this->emit('addedBook');

        $this->reservationItem = new ReservationItem();

        $this->reset(['code', 'title']);
    }

    public function removeBook()
    {
        if ($this->reservation->items()->count() == 0) {
            $this->reservation->delete();
            return redirect()->route('reservations.create');
        }
    }

    public function saveReservation()
    {
        $this->resetErrorBag();

        if ($this->reservation->status == 'Pendiente') {
            $this->reservation->status = 'Confirmada';
            $this->reservation->save();
        } else {
            $this->addError('reservation', 'La Reserva ya fue confirmada.');
        }
    }

    public function render()
    {
        return view('livewire.reservations.reservation-create');
    }
}
