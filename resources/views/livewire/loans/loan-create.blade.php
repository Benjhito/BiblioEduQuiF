<div class="web2py_grid">
    <center><h5><b class="text-primary">Préstamos | Nuevo Préstamo</b></h5></center>
    <div class="web2py_console">
        @if(!$member)
            <div class="form-row mt-3 w-25">
                <div class="form-group col-12">
                    @livewire('members.member-search')
                </div>
            </div>
        @else
            <div class="d-flex">
                <div class="text-primary"><b>{{ 'Socio: ' . $member->code . ' - ' . $member->fullName() }}</b></div>
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
                        <label class="text-muted" for="stock">Stock</label>
                        <input wire:model="stock" class="integer form-control text-center w-100" type="text" id="stock" name="stock" readonly="on" />
                    </div>

                    <div class="form-group text-center col-12 col-md-2">
                        <label class="text-muted" for="due_date">Fecha de Vencimiento</label>
                        <input wire:model="loanItem.due_date" class="form-control w-100" type="date" id="due_date" name="due_date" />
                    </div>

                    <div class="form-group col-12 col-md-1 ml-3">
                        <label class="invisible">Agregar</label>
                        <input class="btn btn-primary @if (!$book) disabled @endif" type="submit" value="Agregar" />
                    </div>

                    @if($loan->status == 'Pendiente' && $loan->items()->count() > 0)
                        <div class="form-group col-12 col-md-1 ml-3">
                            <label class="invisible">Confirmar</label>
                            <a wire:click="saveLoan()" wire:loading.attr="disabled" href="#" class="button btn text-white px-2 py-1" style="background-color:lightseagreen" title="Confirma el Préstamo">Confirmar</a>
                        </div>
                    @endif

                    <div class="form-group col-12 col-md-1 ml-4">
                        <label class="invisible">Volver</label>
                        <a class="button btn btn-secondary px-3 py-1" href="{{ route('loans.create') }}" title="Ir a la página de Nuevo Pŕestamo">Volver</a>
                    </div>
                </div>
            </form>

            @if($loan)
                @livewire('loans.loan-items', ['loan' => $loan])
            @endif
        @endif
    </div>
</div>
