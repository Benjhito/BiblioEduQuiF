<div class="web2py_grid">
    <center><h5><b class="text-success">Devoluciones | Consulta de Devoluciones</b></h5></center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <a class="button btn btn-primary text-white mr-3" href="{{ route('devolutions.create') }}" title="Agrega una nueva Devolución a la base de datos">Nueva Devolución</a>

            <input wire:model="search" type="text" name="search" class="form-control" placeholder="Buscar por Nro|Código|Apellido..." />

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

            <button wire:click="clear" class="rounded p-1" title="Limpia el filtro">
                <img class="w-75" src="{{ asset('images/icons8-cancelar-gray.svg') }}" alt="x">
            </button>

            @if($devolutions->count())
                <a class="button btn btn-warning text-white ml-3" target="_blank" rel="noopener noreferrer" href="{{ route('devolutions.list') }}" title="Listado de Devoluciones en formato PDF">Listado pdf</a>

                <a class="button btn btn-success ml-3" href="{{ route('devolutions.export') }}" title="Listado de Devoluciones en formato XLS">Listado xls</a>
            @endif
        </div>

        <div class="web2py_counter text-secondary">Cantidad de Registros: {{ $devolutions->total() }}</div>

        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th wire:click="order('dev_date')" style="text-align:center" role="button">Fecha</th>
                        <th wire:click="order('dev_number')" style="text-align:center" role="button">Nro.</th>
                        <th wire:click="order('member_id')" style="text-align:center" role="button">Socio</th>
                        <th wire:click="order('status')" style="text-align:center" role="button">Estado</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devolutions as $devolution)
                        <tr>
                            <td align="center">{{ $devolution->dev_date->format('d/m/Y') }}</td>
                            <td align="center">{{ $devolution->dev_number }}</td>

                            <td nowrap="nowrap">{{ $devolution->member->code . ' - ' . $devolution->member->fullName() }}</td>
                            <td align="center">{{ $devolution->status }}</td>
                            <td align="center" nowrap="nowrap">
                                <a href="{{ route('devolutions.show', $devolution) }}" class="" title="Ver Devolución">
                                    <img src="{{ asset('images/icons8-ver-64.png') }}" alt="Ver" width="30px">
                                </a>

                                @if($devolution->status == 'Pendiente')
                                    <a href="{{ route('devolutions.edit', $devolution) }}" class="" title="Editar Devolución">
                                        <img src="{{ asset('images/icons8-editar.svg') }}" alt="Editar" width="30px">
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
            </table>
            @if($devolutions->count())
                {{ $devolutions->links('livewire.pagination') }}
            @endif
        </div>
    </div>
</div>
