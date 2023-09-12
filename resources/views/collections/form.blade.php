<div class="d-flex justify-content-center">
    <form class="w-50 bg-light border border-dark rounded p-4 mb-3 mx-5" method="POST" action="{{ $route }}" enctype="multipart/form-data">
        @csrf
        @if($update)
            @method("PUT")
        @endif

        <h5 class="text-center"><b>{{ $update ? 'Editar Colección' : 'Nueva Colección' }}</b></h5>

        <div class="form-row">
            <div class="form-group col-2">
                <label class="col-form-label text-secondary" for="code" id="code__label"><b>Cód.Int.</b></label>
                <input class="string form-control" id="code" name="code" type="text" value="{{ $collection->code }}" readonly="on" />
            </div>

            <div class="form-group col-10">
                <label class="col-form-label text-secondary" for="name" id="name__label"><b>Nombre</b></label>
                <input class="string form-control" id="name" name="name" type="text" value="{{ old('name') ?? $collection->name }}" maxlength="30" autofocus="on" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="col-form-label text-secondary" for="descrip" id="descrip__label"><b>Descripción</b></label>
                <input class="string form-control" id="descrip" name="descrip" type="text" value="{{ old('descrip') ?? $collection->descrip }}" maxlength="40" />
            </div>
        </div>

        @if($collection->image)
            <div class="form-row">
                <div class="form-group col-12 text-center">
                    <p class="col-form-label text-secondary"><b>Imagen Actual</b></p>
                    <img width="120px" src="/storage/{{ $collection->image }}">
                    <label class="form-check-label" for="delete_image" id="delete_image__label"></label>
                    <div>
                        <input class="form-check-input boolean" id="delete_image" name="delete_image" type="checkbox" />Eliminar
                    </div>
                </div>
            </div>
        @endif

        <div class="form-row">
            <label class="col-form-label text-secondary" for="image" id="image__label"><b>Imagen</b></label>
            <div class="form-group col-12">
                <input class="input-file upload" id="image" name="image" type="file" accept="image/*" />
            </div>
        </div>

        <div class='d-flex justify-content-center pt-2'>
            <a class="button btn btn-secondary mr-5" href="{{ route('collections.index') }}" title="Regresa a la página de Colecciones">Cancelar</a>
            <input class="btn btn-primary" type="submit" value="{{ $update ? 'Actualizar' : 'Crear' }}" />
        </div>
    </form>
</div>
