<div class="web2py_grid">
    <center>
        <h5><b>Editoriales | Gestión de Editoriales</b></h5>
    </center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <a class="button btn btn-primary text-white mr-3" href="{{ route('publishers.create') }}" title="Agrega una nueva Editorial a la base de datos">Nueva Editorial</a>

            <input wire:model="search" type="text" name="search" class="form-control" placeholder="Buscar por Cód.|Nombre|Email..." />

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

            @if($publishers->count())
                <a class="button btn btn-warning text-white ml-3" target="_blank" rel="noopener noreferrer" href="{{ route('publishers.list') }}" title="Listado de Editoriales en formato PDF">Listado pdf</a>

                <a class="button btn btn-success ml-3" href="{{ route('publishers.export') }}" title="Listado de Editoriales en formato XLS">Listado xls</a>
            @endif
        </div>

        <div class="web2py_counter text-secondary">Cantidad de Editoriales: {{ $publishers->total() }}</div>

        <div class="table-responsive mt-3">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th wire:click="order('code')" style="text-align:center" role="button">Cód.</th>
                        <th wire:click="order('name')" style="text-align:center" role="button">Nombre</th>
                        <th wire:click="order('address')" style="text-align:center" role="button">Dirección</th>
                        <th wire:click="order('postcode')" style="text-align:center" role="button">C.P.</th>
                        <th wire:click="order('city')" style="text-align:center" role="button">Ciudad</th>
                        <th wire:click="order('state')" style="text-align:center" role="button">Estado</th>
                        <th wire:click="order('country')" style="text-align:center" role="button">País</th>
                        <th wire:click="order('phone')" style="text-align:center" role="button">Telefono</th>
                        <th wire:click="order('email')" style="text-align:center" role="button">Email</th>
                        <th wire:click="order('url')" style="text-align:center" role="button">Sitio web</th>
                        <th style="text-align:center">Logo</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publishers as $publisher)
                        <tr>
                            <td align="center">{{ $publisher->code }}</a></td>
                            <td nowrap="nowrap">{{ $publisher->fullName() }}</td>
                            <td nowrap="nowrap">{{ $publisher->address }}</td>
                            <td align="center">{{ $publisher->postcode }}</td>
                            <td nowrap="nowrap">{{ $publisher->city }}</td>
                            <td nowrap="nowrap">{{ $publisher->state }}</td>
                            <td nowrap="nowrap">{{ $publisher->country }}</td>
                            <td nowrap="nowrap" align="center">{{ $publisher->phone }}</td>
                            <td>{{ $publisher->email }}</td>
                            <td nowrap="nowrap">{{ $publisher->url }}</td>
                            <td align="center">
                                @if($publisher->logo)
                                    <img width="100px" src="/storage/{{ $publisher->logo }}">
                                @endif
                            </td>
                            <td align="center" nowrap="nowrap">
                                <a href="{{ route('publishers.show', $publisher) }}" class="" title="Ver Editorial">
                                    <img src="{{ asset('images/icons8-ver-64.png') }}" alt="Ver" width="30px">
                                </a>

                                <a href="{{ route('publishers.edit', $publisher) }}" class="" title="Editar Editorial">
                                    <img src="{{ asset('images/icons8-editar.svg') }}" alt="Editar" width="30px">
                                </a>

                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $publisher->id }}" title="Elimina todos los datos de la Editorial">
                                    <img src="{{ asset('images/icons8-basura-rojo.svg') }}" alt="Eliminar" width="30px">
                                </a>
                                @include('livewire.publishers.modal')
                            </td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
            </table>
            @if($publishers->count())
                {{ $publishers->links('livewire.pagination') }}
            @endif
        </div>
    </div>
</div>
