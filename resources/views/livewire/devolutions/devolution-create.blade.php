<div class="web2py_grid">
    <center><h5><b class="text-success">Devoluciones | Nueva Devolución</b></h5></center>
    <div class="web2py_console">
        @if(!$member)
            <div class="form-row mt-3 w-25">
                <div class="form-group col-12">
                    @livewire('members.member-search')
                </div>
            </div>
        @else
            <div class="d-flex">
                <div class="text-success"><b>{{ 'Socio: ' . $member->code . ' - ' . $member->fullName() }}</b></div>
            </div>
        @endif

        @if($member)
            @include('livewire.error-bag')

            <form wire:submit.prevent="addBook" method="POST">
                <div class="form-row w-25">
                    <div class="form-group col-12" >
                        @livewire('books.book-search', ['stock' => true])
                    </div>
                </div>

                <div class="form-row w-100">
                    <div class="form-group text-center col-12 col-md-1">
                        <label class="text-muted" for="code">Código</label>
                        <input wire:model="code" class="form-control w-100" style="text-align: center;" id="code" name="code" type="text" readonly="on" />
                    </div>

                    <div class="form-group text-center col-12 col-md-3">
                        <label class="text-muted" for="title">Título</label>
                        <input wire:model="title" class="string form-control w-100" type="text" id="title" name="title" readonly="on" />
                    </div>

                    <div class="form-group text-center col-12 col-md-1">
                        <label class="text-muted" for="status">Estado</label>
                        <select wire:model="devolutionItem.status" class="form-control generic-widget w-100" id="status">
                            <option disabled selected value="">- Seleccione -</option>
                            <option value="Bueno">Bueno</option>
                            <option value="Aceptable">Aceptable</option>
                            <option value="Dañado">Dañado</option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-md-1 ml-3">
                        <label class="invisible">Agregar</label>
                        <input class="btn btn-success @if (!$book) disabled @endif" type="submit" value="Agregar" />
                    </div>

                    @if($devolution->status == 'Pendiente' && $devolution->items()->count() > 0)
                        <div class="form-group col-12 col-md-1 ml-3">
                            <label class="invisible">Confirmar</label>
                            <a wire:click="saveDevolution()" wire:loading.attr="disabled" href="#" class="button btn text-white px-2 py-1" style="background-color:lightseagreen" title="Confirma el Préstamo">Confirmar</a>
                        </div>
                    @endif

                    <div class="form-group col-12 col-md-1 ml-4">
                        <label class="invisible">Volver</label>
                        <a class="button btn btn-secondary px-3 py-1" href="{{ route('devolutions.create') }}" title="Ir a la página de Nuevo Pŕestamo">Volver</a>
                    </div>
                </div>
            </form>

            @if($devolution)
                @livewire('devolutions.devolution-items', ['devolution' => $devolution])
            @endif
        @endif
    </div>
</div>
