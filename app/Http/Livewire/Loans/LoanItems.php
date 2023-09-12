<?php

namespace App\Http\Livewire\Loans;

use App\Models\Loan;
use Livewire\Component;
use App\Models\LoanItem;

class LoanItems extends Component
{
    public Loan $loan;
    public $loanItems = null;
    public $show = false;

    protected $listeners = [
        'addedBook' => 'render',
    ];

    public function removeBook(LoanItem $loanItem)
    {
        if ($loanItem->loan->status != 'Pendiente') {
            $this->resetErrorBag();
            $this->addError('loan', 'El Préstamo ya fue confirmado.');
            return;
        }

        $this->emit('removedBook');

        $loanItem->delete();
    }

    public function render()
    {
        if ($this->loan)
            $this->loanItems = $this->loan->items()->get();

        return view('livewire.loans.loan-items');
    }
}
