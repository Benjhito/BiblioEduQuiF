<?php

namespace App\Http\Livewire\Devolutions;

use App\Models\Book;
use App\Models\Devolution;
use App\Models\Stock;
use App\Models\Member;
use Livewire\Component;
use App\Models\DevolutionItem;

class DevolutionCreate extends Component
{
    public Member $member;
    public Book $book;
    public Devolution $devolution;
    public DevolutionItem $devolutionItem;
    public $code, $title;

    protected $listeners = [
        'memberSelected' => 'selectMember',
        'bookSelected' => 'selectBook',
        'removedBook' => 'removeBook',
    ];

    protected $rules = [
        'code' => 'required',
        'title' => 'required',
        'devolutionItem.status' => 'required',
    ];

    protected $messages = [
        'code.required' => 'Seleccione un Libro',
        'title.required' => 'Seleccione un Libro',
        'devolutionItem.status.required' => 'Seleccione un Libro',
    ];

    public function mount()
    {
        $this->devolutionItem = new DevolutionItem(['status' => '']);
    }

    public function selectMember(Member $member)
    {
        $devolution = Devolution::memberId($member->id)->devolutionDate(now())->status('Pendiente')->first();

        if (!$devolution) {
            $lastDevolution = Devolution::orderBy('dev_number', 'desc')->first();
            $devNumber = $lastDevolution ? (string)(((int)$lastDevolution->dev_number) + 1) : '1000';

            $devolution = Devolution::create([
                'dev_date' => now(),
                'dev_number' => $devNumber,
                'member_id' => $member->id,
                'status' => 'Pendiente'
            ]);
        }

        $this->member = $member;
        $this->devolution = $devolution;
    }

    public function selectBook(Book $book)
    {
        $this->resetErrorBag();

        $this->devolutionItem->fill([
            'devolution_id' => $this->devolution->id,
            'book_id' => $book->id,
        ]);

        $this->book = $book;
        $this->code = $book->code;
        $this->title = $book->title;
    }

    public function addBook()
    {
        $this->resetErrorBag();

        if ($this->devolution->status != 'Pendiente') {
            $this->addError('devolution', 'La Devolución ya fue confirmada.');
            return;
        }

        $existingItem = $this->devolution->items()
            ->where('book_id', $this->book->id)
            ->first();

        if ($existingItem) {
            $this->addError('book', 'El libro ya está en la Devolución.');
            return;
        }

        $bookId = $this->book->id;

        $loan = $this->member->loans()
            ->whereHas('books', function ($query) use ($bookId) {
                $query->where('books.id', $bookId);
            })
            ->where('status', 'Confirmado')
            ->first();

        if (!$loan) {
            $this->addError('loan', 'El libro no figura entre los libros prestados al Socio.');
            return;
        }

        $this->devolutionItem->devolution_id = $this->devolution->id;
        $this->devolutionItem->book_id = $this->book->id;
        $this->devolutionItem->loan_id = $loan->id;
        $this->devolutionItem->save();

        $this->devolution->save($this->validate());

        $this->emit('addedBook');

        $this->devolutionItem = new DevolutionItem();

        $this->reset(['code', 'title']);
    }

    public function removeBook()
    {
        if ($this->devolution->items()->count() == 0) {
            $this->devolution->delete();
            return redirect()->route('devolutions.create');
        }
    }

    public function saveDevolution()
    {
        $this->resetErrorBag();

        if ($this->devolution->status == 'Pendiente') {
            $devolutionItems = $this->devolution->items()->get();

            foreach ($devolutionItems as $devolutionItem) {
                $stock = Stock::where('book_id', $devolutionItem->book_id)->first();

                if ($stock) {
                    $stock->increment('quantity', 1);
                    $stock->save();
                }
            }

            $this->devolution->status = 'Confirmado';
            $this->devolution->save();
        } else {
            $this->addError('devolution', 'La Devolución ya fue confirmada.');
        }
    }

    public function render()
    {
        return view('livewire.devolutions.devolution-create');
    }
}
