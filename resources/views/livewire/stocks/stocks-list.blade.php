<div class="web2py_grid">
    <center><h5><strong>Stock | Control de Stock</strong></h5></center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <input wire:model="search" type="text" name="search" class="form-control ml-1" placeholder="Buscar por Código o Título..." />

            <select wire:model="providerId" wire:change="resetPage" class="form-control generic-widget" style="width: 18%;" id="provider_id" name="provider_id">
                <option selected value="">- Todos los Proveedores -</option>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->business_name }}</option>
                @endforeach
            </select>

            <select wire:model="publisherId" wire:change="resetPage" class="form-control generic-widget" style="width: 18%;" id="publisher_id" name="publisher_id">
                <option selected value="">- Todos las Editoriales -</option>
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher->id }}">{{ $publisher->fullName() }}</option>
                @endforeach
            </select>

            <select wire:model="categoryId" wire:change="resetPage" class="form-control generic-widget" style="width: 15%;" id="brand_id" name="category_id">
                <option selected value="">- Todas las Categorías -</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->descrip }}</option>
                @endforeach
            </select>

            <select wire:model="collectionId" wire:change="resetPage" class="form-control generic-widget" style="width: 15%;" id="collection_id" name="collection_id">
                <option selected value="">- Todas las Colecciones -</option>
                @foreach($collections as $collection)
                    <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                @endforeach
            </select>

            <select wire:model="perPage" class="form-control text-secondary" style="width: 5%; height: 30px;font-size: 0.875rem;">
                <option value="5">5/pag</option>
                <option value="10">10/pag</option>
                <option value="15">15/pag</option>
                <option value="25">25/pag</option>
                <option value="50">50/pag</option>
                <option value="100">100/pag</option>
            </select>

            <button wire:click="clear" class="rounded mx-1 mb-1 p-1" title="Limpia el filtro">
                <img class="w-75" src="{{ asset('images/icons8-cancelar-gray.svg') }}" alt="x">
            </button>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a class="button btn btn-primary text-white mr-3" href="{{ route('entries.create') }}" title="Agrega un Libro al Stock">Agregar Libro</a>

            @if($stocks->count() > 0)
                <a class="button btn btn-warning text-white ml-3" target="_blank" rel="noopener noreferrer" href="{{ route('stocks.list') }}" title="Listado de Ingresos en formato PDF">Listado pdf</a>

                <a class="button btn btn-success ml-3" href="{{ route('stocks.export') }}" title="Listado de Ingresos en formato XLS">Listado xls</a>
            @endif

            <div class="web2py_counter text-secondary">Cantidad de Títulos: {{ $stocks->total() }}</div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th wire:click="order('books.code')" style="text-align:center" role="button">Cód.Int.</th>
                        <th wire:click="order('books.isbn')" style="text-align:center" role="button">ISBN</th>
                        <th wire:click="order('books.title')" style="text-align:center" role="button">Título</th>
                        <th wire:click="order('books.publisher_id')" style="text-align:center" role="button">Editorial</th>
                        <th wire:click="order('books.collection_id')" style="text-align:center" role="button">Colección</th>
                        <th wire:click="order('quantity')" style="text-align:center" role="button">Stock</th>
                        <th wire:click="order('books.price')" style="text-align:center" role="button">Precio</th>
                        <th wire:click="order('books.disc_rate')" style="text-align:center" role="button">%Desc.</th>
                        <th wire:click="order('books.iva_rate_id')" style="text-align:center" role="button">%IVA</th>
                        <th style="text-align:center" role="button">P.Costo</th>
                        <th style="text-align:center" role="button">Importe</th>
                        <th wire:click="order('location')" style="text-align:center" role="button">Ubicación</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                        <tr>
                            <td align="center">{{ $stock->book->code }}</td>
                            <td align="center">{{ $stock->book->isbn }}</td>
                            <td nowrap="nowrap">{{ $stock->book->title }}</td>
                            <td nowrap="nowrap">{{ $stock->book->publisher->name }}</td>
                            <td nowrap="nowrap">{{ $stock->book->collection->name }}</td>
                            <td align="center"><b>{{ $stock->quantity }}</b></td>
                            <td align="right">{{ number_format($stock->book->price, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($stock->book->disc_rate, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($stock->book->ivaRate->value, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($stock->book->cost, 3, ',', '.') }}</td>
                            <td align="right">{{ number_format($stock->book->amount, 3, ',', '.') }}</td>
                            <td nowrap="nowrap">{{ $stock->location }}</td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
            </table>
            @if($stocks->count() > 0)
                {{ $stocks->links('livewire.pagination') }}
            @endif
        </div>
    <div>
</div>
