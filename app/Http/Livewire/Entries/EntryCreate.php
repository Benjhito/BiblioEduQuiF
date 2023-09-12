<?php

namespace App\Http\Livewire\Entries;

use App\Models\Book;
use App\Models\Entry;
use App\Models\Stock;
use App\Models\IvaRate;
use Livewire\Component;
use App\Models\Provider;
//use Livewire\Attributes\On;

class EntryCreate extends Component
{
    public $providers;
    public $ivaRates;
    public Book $book;
    public Entry $entry;
    public $prevQuant = 0;
    public $update = false;

    protected $listeners = [
        'bookSelected' => 'selectBook',
    ];

    public function mount()
    {
        $this->providers = Provider::all();
        $this->ivaRates = IvaRate::all();
    }

    //#[On('bookSelected')]
    public function selectBook(Book $book)
    {
        $this->book = $book;

        $entry = Entry::where('book_id', $book->id)
            ->where('rec_date', now()->format('Y-m-d'))
            ->first();

        if ($entry) {
            $this->update = true;
        } else {
            $entry = new Entry([
                'rec_date' => now(),
                'book_id' => $book->id,
                'book_code' => $book->code,
                'isbn' => $book->isbn,
                'title' => $book->title,
                'provider_id' => '',
                'quantity' => 0,
                'missing' => 0,
                'surplus' => 0,
                'price' => $book->price,
                'disc_rate' => $book->disc_rate,
                'iva_rate_id' => $book->iva_rate_id,
            ]);
        }

        $this->entry = $entry;
    }

    protected function rules()
    {
        return [
            'entry.rec_date' => ['required'],// 'date'],
            'entry.book_id' => ['required', 'exists:books,id'],
            'entry.book_code' => ['required', 'max:5'],
            'entry.isbn' => ['nullable', 'string', 'max:20'],
            'entry.title' => ['required', 'string', 'max:100'],
            'entry.provider_id' => ['required', 'exists:providers,id'],
            'entry.quantity' => ['required', 'numeric', 'min:1'],
            'entry.price' => ['required', 'numeric', 'min:1'],
            'entry.missing' => ['required', 'numeric', 'min:0'],
            'entry.surplus' => ['required', 'numeric', 'min:0'],
            'entry.disc_rate' => ['required', 'numeric', 'min:0'],
            'entry.iva_rate_id' => ['required', 'exists:iva_rates,id'],
        ];
    }

    protected function messages()
    {
        return [
            'entry.rec_date.required' => 'Ingrese la Fecha de Recepción',
            'entry.book_id.required' => 'Ingrese el ID del Libro',
            'entry.book_id.exists' => 'El Libro no existe en la Base de Datos',
            'entry.book_code.required' => 'Ingrese el Código del Libro',
            'entry.book_code.max' => 'El Código de Libro es de 5 caracteres',
            'entry.isbn.max' => 'El ISBN tiene un máx. de 18 caracteres',
            'entry.title.required' => 'Ingrese el Título del Libro',
            'entry.title.max' => 'La longitud máxima del Título del Libro es de 100 caracteres',
            'entry.provider_id.required' => 'Seleccione el Proveedor del Libro',
            'entry.provider_id.exists' => 'El Proveedor no existe en la Base de Datos',
            'entry.quantity.required' => 'Ingrese la Cantidad recibida del Libro',
            'entry.quantity.min' => 'La Cantidad debe ser mayor que 0',
            'entry.price.required' => 'Ingrese el Precio del Libro',
            'entry.price.min' => 'El Precio debe ser mayor o igual que 0',
            'entry.missing.required' => 'Ingrese un valor mayor o igual a 0 para el Faltante',
            'entry.missing.min' => 'El Faltante mímimo es 0',
            'entry.surplus.required' => 'Ingrese un valor mayor o igual a 0 para el Sobrante',
            'entry.surplus.min' => 'El Sobrante mímimo es 0',
            'entry.disc_rate.required' => 'Ingrese el Porcentaje de Descuento del Libro',
            'entry.disc_rate.min' => 'El campo Porcentaje de Descuento debe ser mayor o igual que 0',
            'entry.iva_rate_id.required' => 'Ingrese el % de IVA del Libro',
            'entry.iva_rate_id.exists' => 'El campo Porcentaje de IVA seleccionado no es válido',
        ];
    }

    public function saveEntry()
    {
        //$validatedData = $this->validate();
        $this->entry->save($this->validate());

        $quantity = $this->entry->quantity - $this->entry->missing + $this->entry->surplus - $this->prevQuant;

        $stock = Stock::where('book_id', $this->book->id)->first();

        if ($stock) {
            $stock->update(['quantity' => $stock->quantity + $quantity]);
        } else {
            Stock::create([
                'book_id' => $this->book->id,
                'quantity' => $quantity,
                'location' => '',
            ]);
        }

        $this->book->price = $this->entry->price;
        $this->book->save();

        $this->book->providers()->syncWithoutDetaching($this->entry->provider_id);

        if ($this->update) {
            return redirect()->route('entries.index')->with('success', 'El Ingreso se guardó correctamente.');
        } else {
            return redirect()->route('entries.create')->with('success', 'El Ingreso se actualizó correctamente.');
        }
    }

    public function render()
    {
        return view('livewire.entries.entry-create');
    }
}
