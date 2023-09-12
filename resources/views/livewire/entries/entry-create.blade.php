<div>
    <h5 class="text-center">
        <b>Ingresos | {{ $update ? 'Consulta ' : 'Carga '}}de Libros Recibidos</b>
    </h5>

    @if(!$book)
        <div class="form-row mt-3 w-25">
            <div class="form-group col-12">
                @livewire('books.book-search')
            </div>
        </div>
    @endif

    @if($entry)
        @include('livewire.error-bag')

        <div class="d-flex justify-content-center">
            <form wire:submit.prevent="saveEntry" class="w-50 bg-light border border-dark rounded p-4 mb-3 mx-5" method="POST">
                <h5 class="text-center">
                    <b>{{ $update ? 'Actualizar Ingreso' : 'Nuevo Ingreso'}}</b>
                </h5>

                <div class="form-row">
                    <div class="form-group col-12 col-md-4">
                        <label class="col-form-label text-secondary" for="rec_date" id="rec_date__label"><b>Fecha de Recepción</b></label>
                        <input wire:model="entry.rec_date" class="form-control" id="rec_date" name="rec_date" type="date" readonly="on" />
                    </div>

                    <div class="form-group col-12 col-md-8">
                        <label class="col-form-label text-secondary" for="title" id="title__label"><b>Título</b></label>
                        <input wire:model="entry.title" class="string form-control" id="title" name="title" type="text" maxlength="50" readonly="on" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-2">
                        <label class="col-form-label text-secondary" for="book_code" id="book_code__label"><b>Cód.Interno</b></label>
                        <input wire:model="entry.book_code" class="string form-control" id="book_code" name="book_code" type="text" readonly="on" />
                    </div>

                    <div class="form-group col-12 col-md-3">
                        <label class="col-form-label text-secondary" for="isbn" id="isbn__label"><b>ISBN</b></label>
                        <input wire:model="entry.isbn" class="string form-control" id="isbn" name="isbn" type="text" />
                    </div>

                    <div class="form-group col-12 col-md-7">
                        <label class="col-form-label text-secondary" for="provider_id" id="provider_id__label"><b>Proveedor</b></label>
                        <select wire:model="entry.provider_id" class="form-control generic-widget" id="provider_id" name="provider_id">
                            <option disabled selected value="">- Seleccione el Proveedor -</option>
                            @foreach($providers as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->business_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-4">
                        <label class="col-form-label text-secondary" for="quantity" id="quantity__label"><b>Cantidad</b></label>
                        <input wire:model="entry.quantity" class="form-control integer" id="quantity" name="quantity" type="number" min="0" step="1" />
                    </div>

                    <div class="form-group col-12 col-md-4">
                        <label class="col-form-label text-secondary" for="missing" id="missing__label"><b>Faltante</b></label>
                        <input wire:model="entry.missing" class="form-control integer" id="missing" name="missing" type="number" min="0" step="1" />
                    </div>

                    <div class="form-group col-12 col-md-4">
                        <label class="col-form-label text-secondary" for="surplus" id="surplus__label"><b>Sobrante</b></label>
                        <input wire:model="entry.surplus" class="form-control integer" id="surplus" name="surplus" type="number" min="0" step="1" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-4">
                        <label class="col-form-label text-secondary" for="price" id="price__label"><b>Precio</b></label>
                        <input wire:model="entry.price" class="form-control decimal" id="price" name="price" type="number" min="1" step="0.01" />
                    </div>

                    <div class="form-group col-12 col-md-4">
                        <label class="col-form-label text-secondary" for="disc_rate" id="disc_rate__label"><b>% Descuento</b></label>
                        <input wire:model="entry.disc_rate" class="form-control decimal" id="disc_rate" name="disc_rate" type="number" min="0" step="0.01" />
                    </div>

                    <div class="form-group col-12 col-md-4">
                        <label class="col-form-label text-secondary" for="iva_rate_id" id="iva_rate_id__label"><b>% IVA</b></label>
                        <select wire:model="entry.iva_rate_id" class="form-control generic-widget" id="iva_rate_id" name="iva_rate_id">
                            <option disabled selected value="">- Seleccione -</option>
                            @foreach($ivaRates as $ivaRate)
                                <option value="{{ $ivaRate->id }}">{{ $ivaRate->descrip }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class='d-flex justify-content-center pt-2'>
                    <a class="button btn btn-secondary mr-5" href="{{ $update ? route('entries.index') : route('entries.create') }}" title="Regresa a la página anterior">Cancelar</a>
                    <input class="btn btn-primary" type="submit" value="{{ $update ? 'Actualizar' : 'Guardar' }}" />
                </div>
            </form>
        </div>
    @endif
</div>
