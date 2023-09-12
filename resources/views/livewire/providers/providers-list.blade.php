<div class="web2py_grid">
    <center>
        <h5><b>Proveedores | Gestión de Proveedores</b></h5>
    </center>
    <div class="web2py_console mt-3">
        <div class="d-flex">
            <a class="button btn btn-primary text-white mr-3" href="{{ route('providers.create') }}" title="Agrega un nuevo Proveedor a la base de datos">Nuevo Proveedor</a>

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

            @if($providers->count())
                <a class="button btn btn-warning text-white ml-3" target="_blank" rel="noopener noreferrer" href="{{ route('providers.list') }}" title="Listado de Proveedores en formato PDF">Listado pdf</a>

                <a class="button btn btn-success ml-3" href="{{ route('providers.export') }}" title="Listado de Proveedores en formato XLS">Listado xls</a>
            @endif
        </div>

        <div class="web2py_counter text-secondary">Cantidad de Proveedores: {{ $providers->total() }}</div>

        <div class="table-responsive mt-3">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th wire:click="order('code')" style="text-align:center" role="button">Cód.</th>
                        <th wire:click="order('business_name')" style="text-align:center" role="button">Nombre</th>
                        <th wire:click="order('address')" style="text-align:center" role="button">Dirección</th>
                        <th wire:click="order('postcode')" style="text-align:center" role="button">C.P.</th>
                        <th wire:click="order('locality')" style="text-align:center" role="button">Localidad</th>
                        <th wire:click="order('province')" style="text-align:center" role="button">Provincia</th>
                        <th wire:click="order('country')" style="text-align:center" role="button">País</th>
                        <th wire:click="order('phone1')" style="text-align:center" role="button">Tel.1</th>
                        <th wire:click="order('phone2')" style="text-align:center" role="button">Tel.2</th>
                        <th wire:click="order('email')" style="text-align:center" role="button">Email</th>
                        <th wire:click="order('url')" style="text-align:center" role="button">Sitio web</th>
                        <th wire:click="order('acc_type')" style="text-align:center" role="button">Cuenta</th>
                        <th wire:click="order('acc_number')" style="text-align:center" role="button">Nro.Cta</th>
                        <th wire:click="order('cuit')" style="text-align:center" role="button">CUIT</th>
                        <th wire:click="order('iva_type_id')" style="text-align:center" role="button">Tipo IVA</th>
                        <th wire:click="order('inv_type')" style="text-align:center" role="button">Tipo Fact.</th>
                        <th wire:click="order('contact')" style="text-align:center" role="button">Contacto</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($providers as $provider)
                        <tr>
                            <td align="center">{{ $provider->code }}</a></td>
                            <td nowrap="nowrap">{{ $provider->business_name }}</td>
                            <td nowrap="nowrap">{{ $provider->address }}</td>
                            <td align="center">{{ $provider->postcode }}</td>
                            <td nowrap="nowrap">{{ $provider->locality }}</td>
                            <td nowrap="nowrap">{{ $provider->province }}</td>
                            <td nowrap="nowrap">{{ $provider->country }}</td>
                            <td nowrap="nowrap" align="center">{{ $provider->phone1 }}</td>
                            <td nowrap="nowrap" align="center">{{ $provider->phone2 }}</td>
                            <td>{{ $provider->email }}</td>
                            <td nowrap="nowrap">{{ $provider->url }}</td>
                            <td align="center" nowrap="nowrap">{{ $provider->acc_type }}</td>
                            <td align="center">{{ $provider->acc_number }}</td>
                            <td nowrap="nowrap" align="center">{{ $provider->cuit }}</td>
                            <td nowrap="nowrap">{{ $provider->ivaType->descrip }}</td>
                            <td align="center">{{ $provider->inv_type }}</td>
                            <td nowrap="nowrap">{{ $provider->contact }}</td>
                            <td align="center" nowrap="nowrap">
                                <a href="{{ route('providers.show', $provider) }}" class="" title="Ver Proveedor">
                                    <img src="{{ asset('images/icons8-ver-64.png') }}" alt="Ver" width="30px">
                                </a>

                                <a href="{{ route('providers.edit', $provider) }}" class="" title="Editar Proveedor">
                                    <img src="{{ asset('images/icons8-editar.svg') }}" alt="Editar" width="30px">
                                </a>

                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $provider->id }}" title="Elimina todos los datos del Proveedor">
                                    <img src="{{ asset('images/icons8-basura-rojo.svg') }}" alt="Eliminar" width="30px">
                                </a>
                                @include('livewire.providers.modal')
                            </td>
                        </tr>
                    @empty
                        @include("livewire.empty")
                    @endforelse
                </tbody>
            </table>
            @if($providers->count())
                {{ $providers->links('livewire.pagination') }}
            @endif
        </div>
    </div>
</div>
