<div class="web2py_grid">
    <center><h5><b>Libros | Gestión de Libros</b></h5></center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <input wire:model="search" type="text" name="search" class="form-control" placeholder="Buscar por Código|Título|Autor..." />

            <select wire:model="providerId" wire:change="resetPage" class="form-control generic-widget" style="width: 18%;" id="provider_id" name="provider_id">
                <option selected value="">- Todas los Proveedores -</option>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->fullName() }}</option>
                @endforeach
            </select>

            <select wire:model="publisherId" wire:change="resetPage" class="form-control generic-widget" id="publisher_id" name="publisher_id">
                <option selected value="">- Todos las Editoriales -</option>
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher->id }}">{{ $publisher->fullName() }}</option>
                @endforeach
            </select>

            <select wire:model="categoryId" wire:change="resetPage" class="form-control generic-widget" style="width: 15%;" id="category_id" name="category_id">
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

            <button wire:click="clear" class="rounded p-1" title="Limpia el filtro">
                <img class="w-75" src="{{ asset('images/icons8-cancelar-gray.svg') }}" alt="x">
            </button>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a class="button btn btn-primary text-white mr-3" href="{{ route('books.create') }}" title="Agrega un nuevo Libro a la base de datos">Nuevo Libro</a>

            @if($books->count())
                <a class="button btn btn-warning text-white ml-3" target="_blank" rel="noopener noreferrer" href="{{ route('books.list') }}" title="Listado de Libros en formato PDF">Listado pdf</a>

                <a class="button btn btn-success ml-3" href="{{ route('books.export') }}" title="Listado de Libros en formato XLS">Listado xls</a>
            @endif

            <div class="web2py_counter text-secondary">Cantidad de Libros: {{ $books->total() }}</div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                    <th wire:click="order('code')" style="text-align:center" role="button">Cód.Int.</th>
                    <th wire:click="order('title')" style="text-align:center" role="button">Título</th>
                    <th wire:click="order('subtitle')" style="text-align:center" role="button">Subtítulo</th>
                    <th wire:click="order('descrip')" style="text-align:center" role="button">Descripción</th>
                    <th wire:click="order('author')" style="text-align:center" role="button">Autor</th>
                    <th wire:click="order('edition')" style="text-align:center" role="button">Edición</th>
                    <th wire:click="order('pub_year')" style="text-align:center" role="button">Año Pub.</th>
                    <th wire:click="order('isbn')" style="text-align:center" role="button">ISBN</th>
                    <th wire:click="order('collection_id')" style="text-align:center" role="button">Colección</th>
                    <th wire:click="order('publisher')" style="text-align:center" role="button">Editorial</th>
                    <th wire:click="order('binding')" style="text-align:center" role="button">Encuadernación</th>
                    <th wire:click="order('page_count')" style="text-align:center" role="button">Páginas</th>
                    <th wire:click="order('format')" style="text-align:center" role="button">Formato</th>
                    <th wire:click="order('tome_count')" style="text-align:center" role="button">Tomos</th>
                    <th wire:click="order('weight')" style="text-align:center" role="button">Peso (g)</th>
                    <th wire:click="order('price')" style="text-align:center" role="button">Precio</th>
                    <th wire:click="order('disc_rate')" style="text-align:center" role="button">%Desc.</th>
                    <th wire:click="order('iva_rate_id')" style="text-align:center" role="button">%IVA</th>
                    <th style="text-align:center">Stock</th>
                    <th style="text-align:center">Ubicación</th>
                    <th wire:click="order('status')" style="text-align:center" role="button">Estado</th>
                    <th style="text-align:center">Imagen</th>
                    <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td align="center">{{ $book->code }}</td>
                            <td nowrap="nowrap">{{ $book->title }}</td>
                            <td nowrap="nowrap">{{ $book->subtitle }}</td>
                            <td nowrap="nowrap">{{ $book->descrip }}</td>
                            <td nowrap="nowrap">{{ $book->author }}</td>
                            <td align="center">{{ $book->edition }}</td>
                            <td align="center">{{ $book->pub_year }}</td>
                            <td align="center" nowrap="nowrap">{{ $book->isbn }}</td>
                            <td nowrap="nowrap">{{ $book->collection->name }}</td>
                            <td nowrap="nowrap">{{ $book->publisher->name }}</td>
                            <td align="center" nowrap="nowrap">{{ $book->binding }}</td>
                            <td align="center">{{ $book->page_count }}</td>
                            <td align="center" nowrap="nowrap">{{ $book->format }}</td>
                            <td align="center">{{ $book->tome_count }}</td>
                            <td align="center">{{ $book->weight }}</td>
                            <td align="right">{{ number_format($book->price, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($book->disc_rate, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($book->ivaRate->value, 2, ',', '.') }}</td>
                            <td align="center">{{ $book->stock->quantity }}</td>
                            <td nowrap="nowrap">{{ $book->stock->location }}</td>
                            <td align="center" nowrap="nowrap">{{ $book->status }}</td>
                            <td align="center">
                                @if($book->image)
                                    <img width="100px" src="/storage/{{ $book->image }}">
                                @endif
                            </td>
                            <td align="center" nowrap="nowrap">
                                <a href="{{ route('books.show', $book) }}" class="" title="Ver Libro">
                                    <img src="{{ asset('images/icons8-ver-64.png') }}" alt="Ver" width="30px">
                                </a>

                                <a href="{{ route('books.edit', $book) }}" class="" title="Editar Libro">
                                    <img src="{{ asset('images/icons8-editar.svg') }}" alt="Editar" width="30px">
                                </a>

                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $book->id }}" title="Elimina todos los datos del Libro">
                                    <img src="{{ asset('images/icons8-basura-rojo.svg') }}" alt="Eliminar" width="30px">
                                </a>
                                @include('livewire.books.modal')
                            </td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
            </table>
            @if($books->count())
                {{ $books->links('livewire.pagination') }}
            @endif
        </div>
    </div>
</div>
