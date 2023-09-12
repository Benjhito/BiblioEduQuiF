<div class="d-flex justify-content-center">
    <form class="w-50 bg-light border border-dark rounded p-4 mb-3 mx-5" method="POST" action="{{ $route }}"  enctype="multipart/form-data">
        @csrf
        @if($update)
            @method("PUT")
        @endif

        <h5 class="text-center">
            <b>{{ $update ? 'Editar Editorial' : 'Nueva Editorial' }}</b>
        </h5>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="code" id="code__label"><b>Cód.Int.</b></label>
                <input class="string form-control" id="code" name="code" type="text" value="{{ $publisher->code }}" readonly="on" />
            </div>

            <div class="form-group col-12 col-md-10">
                <label class="col-form-label text-secondary" for="name" id="name__label"><b>Nombre</b></label>
                <input class="string form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') ?? $publisher->fullName() }}" maxlength="40" autofocus="on" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="col-form-label text-secondary" for="address" id="address__label"><b>Dirección</b></label>
                <input class="string form-control @error('address') is-invalid @enderror" id="address" name="address" type="text" value="{{ old('address') ?? $publisher->address }}" maxlength="50" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="postcode" id="postcode__label"><b>Cód.Postal</b></label>
                <input class="string form-control @error('postcode') is-invalid @enderror" id="postcode" name="postcode" type="text" value="{{ old('postcode') ?? $publisher->postcode }}" maxlength="8" />
            </div>

            <div class="form-group col-12 col-md-10">
                <label class="col-form-label text-secondary" for="city" id="city__label"><b>Ciudad</b></label>
                <input class="string form-control @error('city') is-invalid @enderror" id="city" name="city" type="text" value="{{ old('city') ?? $publisher->city }}" maxlength="40" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-5">
                <label class="col-form-label text-secondary" for="state" id="state__label"><b>Estado</b></label>
                <input class="string form-control @error('state') is-invalid @enderror" id="state" name="state" type="text" value="{{ old('state') ?? $publisher->state }}" maxlength="40" />
            </div>

            <div class="form-group col-12 col-md-5">
                <label class="col-form-label text-secondary" for="country" id="country__label"><b>País</b></label>
                <input class="string form-control @error('country') is-invalid @enderror" id="country" name="country" type="text" value="{{ old('country') ?? $publisher->country }}" maxlength="40" />
            </div>

            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="phone" id="phone__label"><b>Teléfono</b></label>
                <input class="string form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" value="{{ old('phone') ?? $publisher->phone }}" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="col-form-label text-secondary" for="email" id="email__label"><b>Email</b></label>
                <input class="string form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') ?? $publisher->email }}" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="col-form-label text-secondary" for="url" id="url__label"><b>Sitio web</b></label>
                <input class="string form-control @error('url') is-invalid @enderror" id="url" name="url" type="url" value="{{ old('url') ?? $publisher->url }}" />
            </div>
        </div>

        @if($publisher->logo)
            <div class="form-row">
                <div class="form-group col-12 text-center">
                    <p class="col-form-label text-secondary"><b>Logo Actual</b></p>
                    <img width="120px" src="/storage/{{ $publisher->logo }}">
                    <label class="form-check-label" for="delete_logo" id="delete_logo__label"></label>
                    <div>
                        <input class="form-check-input boolean" id="delete_logo" name="delete_logo" type="checkbox" />Eliminar
                    </div>
                </div>
            </div>
        @endif

        <div class="form-row">
            <label class="col-form-label text-secondary" for="logo" id="logo__label"><b>Logo</b></label>
            <div class="form-group col-12">
                <input class="input-file upload" id="logo" name="logo" type="file" accept="image/*" />
            </div>
        </div>

        <div class='d-flex justify-content-center pt-2'>
            <a class="button btn btn-secondary mr-5" href="{{ route('publishers.index') }}" title="Regresa a la página de Gestión de Editoriales">Cancelar</a>
            <input class="btn btn-primary" type="submit" value="{{ $update ? 'Actualizar' : 'Crear' }}" />
        </div>
    </form>
</div>
