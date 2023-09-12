<div class="web2py_grid">
    <center>
        <h5><strong>Categorías | Gestión de Categorías</strong></h5>
    </center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <a class="button btn btn-primary text-white mr-3" href="{{ route('categories.create') }}" title="Agrega una nueva Categoría a la base de datos">Nueva Categoría</a>

            <input wire:model="search" type="text" name="search" class="form-control" placeholder="Buscar por Código|Nombre|Descripción..." />

            <select wire:model="perPage" class="form-control text-secondary" style="width: 5%; height: 30px;font-size: 0.875rem;">
                <option value="5">5/pag</option>
                <option value="10">10/pag</option>
                <option value="15">15/pag</option>
                <option value="25">25/pag</option>
                <option value="50">50/pag</option>
                <option value="100">100/pag</option>
            </select>

            @if($search !== '')
                <button wire:click="clear" class="rounded p-1" title="Limpia el filtro">
                    <img class="w-75" src="{{ asset('images/icons8-cancelar-gray.svg') }}" alt="x">
                </button>
            @endif

            @if($categories->count())
                <a class="button btn btn-warning text-white ml-3" target="_blank" rel="noopener noreferrer" href="{{ route('categories.list') }}" title="Listado de Categorías en formato PDF">Listado pdf</a>

                <a class="button btn btn-success ml-3" href="{{ route('categories.export') }}" title="Listado de Categorías en formato XLS">Listado xls</a>
            @endif
        </div>
        <div class="web2py_counter text-secondary">Cantidad de Categorías: {{ $categories->total() }}</div>
        <div class="table-responsive mt-3">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th wire:click="order('code')" style="text-align:center" role="button">Cód.Int.</th>
                        <th wire:click="order('name')" style="text-align:center" role="button">Nombre</th>
                        <th wire:click="order('descrip')" style="text-align:center" role="button">Descripción</th>
                        <th style="text-align:center">Imagen</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td align="center">{{ $category->code }}</td>
                            <td nowrap="nowrap">{{ $category->name }}</td>
                            <td nowrap="nowrap">{{ $category->descrip }}</td>
                            <td align="center">
                                @if($category->image)
                                    <img width="100px" src="/storage/{{ $category->image }}">
                                @endif
                            </td>
                            <td align="center" nowrap="nowrap">
                                <a href="{{ route('categories.edit', $category) }}" class="" title="Editar Categoría">
                                    <img src="{{ asset('images/icons8-editar.svg') }}" alt="Editar" width="30px">
                                </a>

                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $category->id }}" title="Elimina todos los datos de la Categoría">
                                    <img src="{{ asset('images/icons8-basura-rojo.svg') }}" alt="Eliminar" width="30px">
                                </a>
                                @include('livewire.categories.modal')
                            </td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
            </table>
            @if($categories->count())
                {{ $categories->links('livewire.pagination') }}
            @endif
        </div>
    </div>
</div>
