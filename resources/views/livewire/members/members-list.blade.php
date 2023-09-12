<div class="web2py_grid">
    <center><h5><b class="text-primary">Socios | Gestión de Socios</b></h5></center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <a class="button btn btn-primary d-flex align-items-center text-white text-nowrap mr-3" href="{{ route('members.create') }}" title="Agrega un nuevo Socio a la base de datos">Nuevo Socio</a>

            <input wire:model="search" type="text" name="search" class="form-control" placeholder="Buscar por Cód.|Apellido|DNI|Email..." />

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

            @if($members->count())
                <a class="button btn btn-warning d-flex align-items-center text-white text-nowrap ml-3" target="_blank" rel="noopener noreferrer" href="{{ route('members.list') }}" title="Listado de Socios en formato PDF">Listado pdf</a>

                <a class="button btn btn-success d-flex align-items-center text-nowrap ml-3" href="{{ route('members.export') }}" title="Listado de Socios en formato XLS">Listado xls</a>
            @endif
        </div>

        <div class="web2py_counter text-secondary">Cantidad de Socios: {{ $members->total() }}</div>

        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th wire:click="order('code')" style="text-align:center" role="button">Cód.</th>
                        <th wire:click="order('last_name')" style="text-align:center" role="button">Apellidos</th>
                        <th wire:click="order('first_name')" style="text-align:center" role="button">Nombres</th>
                        <th wire:click="order('doc_number')" style="text-align:center" role="button">DNI</th>
                        <th wire:click="order('address')" style="text-align:center" role="button">Domicilio</th>
                        <th wire:click="order('postcode')" style="text-align:center" role="button">Cód.Postal</th>
                        <th wire:click="order('locality')" style="text-align:center" role="button">Localidad</th>
                        <th wire:click="order('mobile')" style="text-align:center" role="button">Móvil</th>
                        <th wire:click="order('email')" style="text-align:center" role="button">Email</th>
                        <th wire:click="order('adm_date')" style="text-align:center" role="button">Fecha Adm.</th>
                        <th wire:click="order('status')" style="text-align:center" role="button">Estado</th>
                        <th wire:click="order('notes')" style="text-align:center" role="button">Observ.</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td align="center">{{ $member->code }}</td>
                            <td nowrap="nowrap">{{ $member->last_name }}</td>
                            <td nowrap="nowrap">{{ $member->first_name }}</td>
                            <td nowrap="nowrap" align="center">{{ $member->doc_number }}</td>
                            <td nowrap="nowrap">{{ $member->address }}</td>
                            <td align="center">{{ $member->postcode }}</td>
                            <td nowrap="nowrap">{{ $member->locality }}</td>
                            <td nowrap="nowrap" align="center">{{ $member->mobile }}</td>
                            <td>{{ $member->email }}</td>
                            <td align="center">{{ $member->adm_date ? $member->adm_date->format('d/m/Y') : '' }}</td>
                            <td align="center">{{ $member->status }}</td>
                            <td nowrap="nowrap">{{ $member->notes }}</td>
                            <td align="center" nowrap="nowrap">
                                <a href="{{ route('members.show', $member) }}" class="" title="Ver Socio">
                                    <img src="{{ asset('images/icons8-ver-64.png') }}" alt="Ver" width="30px">
                                </a>

                                <a href="{{ route('members.edit', $member) }}" class="" title="Editar Socio">
                                    <img src="{{ asset('images/icons8-editar.svg') }}" alt="Editar" width="30px">
                                </a>

                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $member->id }}" title="Elimina todos los datos del Socio">
                                    <img src="{{ asset('images/icons8-basura-rojo.svg') }}" alt="Eliminar" width="30px">
                                </a>
                                @include('livewire.members.modal')
                            </td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
            </table>
            @if($members->count())
                {{ $members->links('livewire.pagination') }}
            @endif
        </div>
    </div>
</div>
