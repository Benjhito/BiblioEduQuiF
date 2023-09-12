<div class="d-flex justify-content-center">
    <form class="w-50 bg-light border border-dark rounded p-4 mb-3 mx-5" method="POST" action="{{ $route }}" enctype="multipart/form-data">
        @csrf
        @if($update)
            @method("PUT")
        @endif

        <h5 class="text-center"><b>{{ $update ? 'Editar Libro' : 'Nuevo Libro' }}</b></h5>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="code" id="code__label"><b>Cód.Int.</b></label>
                <input class="string form-control @error('code') is-invalid @enderror" id="code" name="code" type="text" value="{{ $book->code }}" readonly="on" />
            </div>

            <div class="form-group col-5">
                <label class="col-form-label text-secondary" for="title" id="title__label"><b>Título</b></label>
                <input class="string form-control @error('title') is-invalid @enderror" id="title" name="title" type="text" value="{{ old('title') ?? $book->title }}" maxlength="100" autofocus="on" />
            </div>

            <div class="form-group col-5">
                <label class="col-form-label text-secondary" for="subtitle" id="subtitle__label"><b>Subtítulo</b></label>
                <input class="string form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" type="text" value="{{ old('subtitle') ?? $book->subtitle }}" maxlength="200" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-8">
                <label class="col-form-label text-secondary" for="descrip" id="descrip__label"><b>Descripción</b></label>
                <input class="string form-control @error('descrip') is-invalid @enderror" id="descrip" name="descrip" type="text" value="{{ old('descrip') ?? $book->descrip }}" maxlength="255" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="author" id="author__label"><b>Autor</b></label>
                <input class="string form-control @error('author') is-invalid @enderror" id="author" name="author" type="text" value="{{ old('author') ?? $book->author }}" maxlength="50" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="edition" id="edition__label"><b>Edición</b></label>
                <input class="form-control integer @error('edition') is-invalid @enderror" id="edition" name="edition" type="number" min="1" step="1" value="{{ old('edition') ?? $book->edition }}" />
            </div>

            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="pub_year" id="pub_year__label"><b>Año Public.</b></label>
                <input class="form-control integer @error('pub_year') is-invalid @enderror" id="pub_year" name="pub_year" type="number" min="1" step="1" value="{{ old('pub_year') ?? $book->pub_year }}" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="isbn" id="isbn__label"><b>ISBN</b></label>
                <input class="string form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" type="text" value="{{ old('isbn') ?? $book->isbn }}" maxlength="20" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="collection_id" id="collection_id__label"><b>Colección</b></label>
                <select class="form-control generic-widget" id="collection_id" name="collection_id">
                    <option disabled selected value="">- Seleccione -</option>
                    @foreach($collections as $collection)
                        <option value="{{ $collection->id }}" {{ (old('collection_id') ?? $book->collection_id) == $collection->id ? 'selected' : '' }}>{{ $collection->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="publisher_id" id="publisher_id__label"><b>Editorial</b></label>
                <select class="form-select generic-widget @error('publisher_id') is-invalid @enderror" id="publisher_id" name="publisher_id">
                    <option disabled selected value="">- Seleccione -</option>
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher->id }}" {{ (old('publisher_id') ?? $book->publisher_id) == $publisher->id ? 'selected' : '' }}>{{ $publisher->fullName() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="categories" id="categories__label"><b>Categorías</b></label>
                <select class="form-select" size="3" id="categories" name="categories[]" multiple>
                    <!--option disabled selected value="">- Seleccione -</option-->
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($update ? $book->categories->contains($category->id) : in_array($category->id, old("categories") ?: [])) ? 'selected' : '' }}>{{ $category->descrip }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="binding" id="binding__label"><b>Encuadernación</b></label>
                <input class="string form-control @error('binding') is-invalid @enderror" id="binding" name="binding" type="text" value="{{ old('binding') ?? $book->binding }}" maxlength="20" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="page_count" id="page_count__label"><b>Páginas</b></label>
                <input class="form-control integer @error('page_count') is-invalid @enderror" id="page_count" name="page_count" type="number" min="1" step="1" value="{{ old('page_count') ?? $book->page_count }}" />
            </div>

            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="format" id="format__label"><b>Formato</b></label>
                <input class="string form-control @error('format') is-invalid @enderror" id="format" name="format" type="text" value="{{ old('format') ?? $book->format }}" maxlength="20" />
            </div>

            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="tome_count" id="tome_count__label"><b>Tomos</b></label>
                <input class="form-control integer @error('tome_count') is-invalid @enderror" id="tome_count" name="tome_count" type="number" min="1" step="1" value="{{ old('tome_count') ?? $book->tome_count }}" />
            </div>

            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="weight" id="weight__label"><b>Peso (g)</b></label>
                <input class="form-control integer @error('weight') is-invalid @enderror" id="weight" name="weight" type="number" min="1" step="1" value="{{ old('weight') ?? $book->weight }}" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="status" id="color__label"><b>Estado</b></label>
                <select class="form-control generic-widget" id="status" name="status">
                    <!--option disabled selected value="">- Seleccione -</option-->
                    <option value="Disponible" {{ (old('status') ?? $book->status) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="Prestado" {{ (old('status') ?? $book->status) == 'Prestado' ? 'selected' : '' }}>Prestado</option>
                    <option value="Reservado" {{ (old('status') ?? $book->status) == 'Reservado' ? 'selected' : '' }}>Reservado</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="price" id="price__label"><b>Precio</b></label>
                <input class="form-control decimal @error('price') is-invalid @enderror" id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price') ?? $book->price }}" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="disc_rate" id="disc_rate__label"><b>% Descuento</b></label>
                <input class="form-control decimal @error('disc_rate') is-invalid @enderror" id="disc_rate" name="disc_rate" type="number" min="0" step="0.01" value="{{ old('disc_rate') ?? $book->disc_rate }}" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="iva_rate_id" id="iva_rate_id__label"><b>% IVA</b></label>
                <select class="form-control generic-widget" id="iva_rate_id" name="iva_rate_id">
                    <option disabled selected value="">- Seleccione -</option>
                    @foreach($ivaRates as $ivaRate)
                        <option value="{{ $ivaRate->id }}" {{ (old('iva_rate_id') ?? $book->iva_rate_id) == $ivaRate->id ? 'selected' : '' }}>{{ $ivaRate->descrip }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($book->image)
            <div class="form-row">
                <div class="form-group col-12 text-center">
                    <p class="col-form-label text-secondary"><b>Imagen Actual</b></p>
                    <img width="120px" src="/storage/{{ $book->image }}">
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
            <a class="button btn btn-secondary mr-5" href="{{ route('books.index') }}" title="Regresa a la página de Gestión de Libros">Cancelar</a>
            <input class="btn btn-primary" type="submit" value="{{ $update ? 'Actualizar' : 'Crear' }}" />
        </div>
    </form>
</div>
