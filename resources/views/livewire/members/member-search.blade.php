<div>
    <input wire:model.debounce.500ms="search" type="text" name="search" style="width: 100%;" class="form-control" placeholder="Buscar Socio por Código o Apellido..." autocomplete="off" autofocus="on" />

    @if(!empty($search))
        <div class="web2py_grid mt-2 w-50" style="background: #f2f3f4; overflow: auto; position: fixed; z-index: 99; border: 1px solid DeepSkyBlue;">
            <div class="web2py_console">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align:center" role="button">Código</th>
                                <th style="text-align:center" role="button">Apellidos y Nombres</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td align="center">
                                        <a wire:click="selectMember({{ $member }})" href="#" title="Ingresa datos del Socio">
                                            {{ $member->code }}
                                        </a>
                                    </td>
                                    <td nowrap="nowrap">{{ $member->fullName() }}</td>
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
            <div>
        </div>
    @endif
</div>
