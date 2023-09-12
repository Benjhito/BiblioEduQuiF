<?php

namespace App\Http\Livewire\Loans;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Stock;
use App\Models\Member;
use Livewire\Component;
use App\Models\LoanItem;

class LoanCreate extends Component
{
    public Member $member;
    public Book $book;
    public Loan $loan;
    public LoanItem $loanItem;
    public $code, $title, $stock;

    protected $listeners = [
        'memberSelected' => 'selectMember',
        'bookSelected' => 'selectBook',
        'removedBook' => 'removeBook',
    ];

    protected $rules = [
        'code' => 'required',
        'title' => 'required',
        'stock' => 'required',
        'loanItem.due_date' => 'required',
    ];

    protected $messages = [
        'code.required' => 'Seleccione un Libro',
        'title.required' => 'Seleccione un Libro',
        'stock.required' => 'Seleccione un Libro',
        'loanItem.due_date.required' => 'Ingrese la Fecha de Vencimiento',
    ];

    public function mount()
    {
        $this->loanItem = new LoanItem();
    }

    public function selectMember(Member $member)
    {
        $loan = Loan::memberId($member->id)->loanDate(now())->status('Pendiente')->first();

        if (!$loan) {
            $lastLoan = Loan::orderBy('loan_number', 'desc')->first();
            $loanNumber = $lastLoan ? (string)(((int)$lastLoan->loan_number) + 1) : '1000';

            $loan = Loan::create([
                'loan_date' => now(),
                'loan_number' => $loanNumber,
                'member_id' => $member->id,
                'status' => 'Pendiente'
            ]);
        }

        $this->member = $member;
        $this->loan = $loan;
    }

    public function selectBook(Book $book)
    {
        $this->resetErrorBag();

        $this->loanItem->fill([
            'loan_id' => $this->loan->id,
            'book_id' => $book->id,
            'due_date' => now()->addDay(3),
        ]);

        $this->book = $book;
        $this->code = $book->code;
        $this->title = $book->title;
        $this->stock = $book->stock->quantity;
    }

    public function addBook()
    {
        $this->resetErrorBag();

        if ($this->loan->status != 'Pendiente') {
            $this->addError('loan', 'El Préstamo ya fue confirmado.');
            return;
        }

        if ($this->stock < 1) {
            $this->addError('quantity', 'No hay ningún ejemplar disponible.');
            return;
        }

        if ($this->loanItem->due_date < now()) {
            $this->addError('date', 'La fecha de vencimiento debe ser posterior a la fecha actual.');
            return;
        }

        $existingItem = $this->loan->items()
            ->where('book_id', $this->book->id)
            ->first();

        if ($existingItem) {
            $this->addError('book', 'El libro ya está en el Préstamo.');
            return;
        }

        $this->loanItem->loan_id = $this->loan->id;
        $this->loanItem->book_id = $this->book->id;
        $this->loanItem->save();

        $this->loan->save($this->validate());

        $this->emit('addedBook');

        $this->loanItem = new LoanItem();

        $this->reset(['code', 'title', 'stock']);
    }

    public function removeBook()
    {
        if ($this->loan->items()->count() == 0) {
            $this->loan->delete();
            return redirect()->route('loans.create');
        }
    }

    public function saveLoan()
    {
        $this->resetErrorBag();

        if ($this->loan->status == 'Pendiente') {
            $loanItems = $this->loan->items()->get();

            foreach ($loanItems as $loanItem) {
                $stock = Stock::where('book_id', $loanItem->book_id)->first();

                if ($stock) {
                    if ($stock->quantity < 1) {
                        $book = $stock->book->code . '-' . $stock->book->title;
                        $this->addError('stock', 'Libro ' . $book . ': Stock insuficiente.');
                        return;
                    } else {
                        $stock->decrement('quantity', 1);
                        $stock->save();
                    }
                }
            }

            $this->loan->status = 'Confirmado';
            $this->loan->save();
        } else {
            $this->addError('loan', 'El Préstamo ya fue confirmado.');
        }
    }

    public function render()
    {
        return view('livewire.loans.loan-create');
    }
}
