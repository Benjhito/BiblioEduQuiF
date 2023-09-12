<?php

namespace App\Http\Livewire\Devolutions;

use App\Models\Devolution;
use Livewire\Component;
use App\Models\DevolutionItem;

class DevolutionItems extends Component
{
    public Devolution $devolution;
    public $devolutionItems = null;
    public $show = false;

    protected $listeners = [
        'addedBook' => 'render',
    ];

    public function removeBook(DevolutionItem $devolutionItem)
    {
        if ($devolutionItem->devolution->status != 'Pendiente') {
            $this->resetErrorBag();
            $this->addError('devolution', 'La Devolución ya fue confirmada.');
            return;
        }

        $this->emit('removedBook');

        $devolutionItem->delete();
    }

    public function render()
    {
        if ($this->devolution)
            $this->devolutionItems = $this->devolution->items()->get();

        return view('livewire.devolutions.devolution-items');
    }
}
