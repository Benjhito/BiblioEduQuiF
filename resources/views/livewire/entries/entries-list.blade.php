<div class="web2py_grid">
    <center><h5><strong>Ingresos | Consulta de Libros Recibidos</strong></h5></center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <input wire:model="search" type="text" name="search" class="form-control ml-1" placeholder="Buscar por Código|ISBN|Título..." />

            <select wire:model="providerId" wire:change="resetPage" class="form-control generic-widget" style="width: 15%;" id="provider_id" name="provider_id">
                <option selected value="">- Todos los Proveedores -</option>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->business_name }}</option>
                @endforeach
            </select>

            <select wire:model="publisherId" wire:change="resetPage" class="form-control generic-widget" style="width: 15%;" id="publisher_id" name="publisher_id">
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

            <input wire:model="iniDate" class="form-control" style="width: 15%;" name="iniDate" type="date" />
            <input wire:model="finDate" class="form-control" style="width: 15%;" name="finDate" type="date" />

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
            <a class="button btn btn-primary text-white" href="{{ route('entries.create') }}" title="Ir a la página de Carga de Libros Recibidos">Nuevo Ingreso</a>

            @if($entries->count())
                <a class="button btn btn-warning text-white" target="_blank" rel="noopener noreferrer" href="{{ route('entries.list') }}" title="Listado de Ingresos en formato PDF">Listado pdf</a>

                <a class="button btn btn-success" href="{{ route('entries.export') }}" title="Listado de Ingresos en formato XLS">Listado xls</a>
            @endif

            <div class="web2py_counter text-secondary">Cantidad de Libros: {{ $entries->total() }}</div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center">FechaRec.</th>
                        <th style="text-align:center">Cód.Int.</th>
                        <th style="text-align:center">ISBN</th>
                        <th style="text-align:center">Título</th>
                        <th style="text-align:center">Proveedor</th>
                        <th style="text-align:center">Editorial</th>
                        <th style="text-align:center">Colección</th>
                        <th style="text-align:center">Cant.</th>
                        <th style="text-align:center">Falt.</th>
                        <th style="text-align:center">Sobr.</th>
                        <th style="text-align:center">Precio</th>
                        <th style="text-align:center">%Desc.</th>
                        <th style="text-align:center">%IVA</th>
                        <th style="text-align:center">P.Costo</th>
                        <th style="text-align:center">Importe</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{--
                    @php
                        $units = $missing = $surplus = $total = 0;
                    @endphp
                    --}}
                    @forelse($entries as $entry)
                        {{--
                        @php
                            $units += $entry->quantity;
                            $missing += $entry->missing;
                            $surplus += $entry->surplus;
                            $total += $entry->amount;
                        @endphp
                        --}}
                        <tr>
                            <td align="center">{{ $entry->rec_date->format('d/m/Y') }}</td>
                            <td align="center">{{ $entry->book_code }}</td>
                            <td align="center">{{ $entry->isbn }}</td>
                            <td nowrap="nowrap">{{ $entry->title }}</td>
                            <td nowrap="nowrap">{{ $entry->provider->business_name }}</td>
                            <td nowrap="nowrap">{{ $entry->book->publisher->name }}</td>
                            <td nowrap="nowrap">{{ $entry->book->collection->name }}</td>
                            <td align="center">{{ $entry->quantity }}</td>
                            <td align="center">{{ $entry->missing }}</td>
                            <td align="center">{{ $entry->surplus }}</td>
                            <td align="right">{{ number_format($entry->price, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($entry->disc_rate, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($entry->book->ivaRate->value, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($entry->cost, 3, ',', '.') }}</td>
                            <td align="right">{{ number_format($entry->amount, 3, ',', '.') }}</td>
                            <td align="center" nowrap="nowrap">
                                <a href="{{ route('entries.edit', $entry) }}" class="" title="Editar Ingreso">
                                    <img src="{{ asset('images/icons8-editar.svg') }}" alt="Editar" width="30px">
                                </a>

                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $entry->id }}" title="Elimina el Ingreso">
                                    <img src="{{ asset('images/icons8-basura-rojo.svg') }}" alt="Eliminar" width="30px">
                                </a>
                                @include('livewire.entries.modal')
                            </td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
                {{--
                <tfoot>
                    <tr>
                        <td align="center"><b>Totales</b></td>
                        <td colspan="5"></td>
                        <td align="center"><b>{{ $units }}</b></td>
                        <td align="center"><b>{{ $missing }}</b></td>
                        <td align="center"><b>{{ $surplus }}</b></td>
                        <td colspan="5"></td>
                        <td align="right"><b>$ {{ number_format($total, 2, ',', '.') }}</b></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                --}}
            </table>
            @if($entries->count())
                {{ $entries->links('livewire.pagination') }}
            @endif
        </div>
    </div>
</div>
