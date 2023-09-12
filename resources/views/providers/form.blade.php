<div class="d-flex justify-content-center">
    <form class="w-50 bg-light border border-dark rounded p-4 mb-3 mx-5" method="POST" action="{{ $route }}">
        @csrf
        @if($update)
            @method("PUT")
        @endif

        <h5 class="text-center">
            <b>{{ $update ? 'Editar Proveedor' : 'Nuevo Proveedor' }}</b>
        </h5>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="code" id="code__label"><b>Cód.Int.</b></label>
                <input class="string form-control" id="code" name="code" type="text" value="{{ $provider->code }}" readonly="on" />
            </div>

            <div class="form-group col-12 col-md-10">
                <label class="col-form-label text-secondary" for="business_name" id="business_name__label"><b>Razón Social</b></label>
                <input class="string form-control @error('business_name') is-invalid @enderror" id="business_name" name="business_name" type="text" value="{{ old('business_name') ?? $provider->business_name }}" maxlength="40" autofocus="on" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="col-form-label text-secondary" for="address" id="address__label"><b>Dirección</b></label>
                <input class="string form-control @error('address') is-invalid @enderror" id="address" name="address" type="text" value="{{ old('address') ?? $provider->address }}" maxlength="50" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="postcode" id="postcode__label"><b>Cód.Postal</b></label>
                <input class="string form-control @error('postcode') is-invalid @enderror" id="postcode" name="postcode" type="text" value="{{ old('postcode') ?? $provider->postcode }}" maxlength="8" />
            </div>

            <div class="form-group col-12 col-md-10">
                <label class="col-form-label text-secondary" for="locality" id="locality__label"><b>Localidad</b></label>
                <input class="string form-control @error('locality') is-invalid @enderror" id="locality" name="locality" type="text" value="{{ old('locality') ?? $provider->locality }}" maxlength="40" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-6">
                <label class="col-form-label text-secondary" for="province" id="province__label"><b>Provincia</b></label>
                <input class="string form-control @error('province') is-invalid @enderror" id="province" name="province" type="text" value="{{ old('province') ?? $provider->province }}" maxlength="40" />
            </div>

            <div class="form-group col-12 col-md-6">
                <label class="col-form-label text-secondary" for="country" id="country__label"><b>País</b></label>
                <input class="string form-control @error('country') is-invalid @enderror" id="country" name="country" type="text" value="{{ old('country') ?? $provider->country }}" maxlength="40" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-6">
                <label class="col-form-label text-secondary" for="phone1" id="phone1__label"><b>Teléfono 1</b></label>
                <input class="string form-control @error('phone1') is-invalid @enderror" id="phone1" name="phone1" type="text" value="{{ old('phone1') ?? $provider->phone1 }}" />
            </div>

            <div class="form-group col-12 col-md-6">
                <label class="col-form-label text-secondary" for="phone2" id="phone2__label"><b>Teléfono 2</b></label>
                <input class="string form-control @error('phone2') is-invalid @enderror" id="phone2" name="phone2" type="text" value="{{ old('phone2') ?? $provider->phone2 }}" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="col-form-label text-secondary" for="email" id="email__label"><b>Email</b></label>
                <input class="string form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') ?? $provider->email }}" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="col-form-label text-secondary" for="url" id="url__label"><b>Sitio web</b></label>
                <input class="string form-control @error('url') is-invalid @enderror" id="url" name="url" type="url" value="{{ old('url') ?? $provider->url }}" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="acc_type" id="acc_type__label"><b>Tipo de Cuenta</b></label>
                <select class="form-control generic-widget" id="acc_type" name="acc_type">
                    <!--option disabled selected value="">Seleccione</option-->
                    <option value="CC" {{ (old('acc_type') ?? $provider->acc_type) == 'CC' ? 'selected' : '' }}>Cuenta Corriente</option>
                    <option value="CA" {{ (old('acc_type') ?? $provider->acc_type) == 'CA' ? 'selected' : '' }}>Caja de Ahorro</option>
                </select>
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="acc_number" id="acc_number__label"><b>Nro de Cuenta</b></label>
                <input class="string form-control @error('acc_number') is-invalid @enderror" id="acc_number" name="acc_number" type="text" value="{{ old('acc_number') ?? $provider->acc_number }}" maxlength="15" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="cuit" id="cuit__label"><b>CUIT</b></label>
                <input class="string form-control @error('cuit') is-invalid @enderror" id="cuit" name="cuit" type="text" value="{{ old('cuit') ?? $provider->cuit }}" maxlength="13" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="iva_type_id" id="iva_type_id__label"><b>Tipo de IVA</b></label>
                <select class="form-control generic-widget" id="iva_type_id" name="iva_type_id">
                    <!--option disabled selected value="">- Seleccione -</option-->
                    @foreach($ivaTypes as $ivaType)
                    <option value="{{ $ivaType->id }}" {{ (old('iva_type_id') ?? $provider->iva_type_id) == $ivaType->id ? 'selected' : '' }}>{{ $ivaType->descrip }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="inv_type" id="inv_type__label"><b>Tipo Fact.</b></label>
                <select class="form-control generic-widget" id="inv_type" name="inv_type">
                    <!--option disabled selected value="">Seleccione</option-->
                    <option value="A" {{ (old('inv_type') ?? $provider->inv_type) == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ (old('inv_type') ?? $provider->inv_type) == 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ (old('inv_type') ?? $provider->inv_type) == 'C' ? 'selected' : '' }}>C</option>
                    <option value="X" {{ (old('inv_type') ?? $provider->inv_type) == 'X' ? 'selected' : '' }}>X</option>
                </select>
            </div>

            <div class="form-group col-12 col-md-6">
                <label class="col-form-label text-secondary" for="contact" id="contact__label"><b>Contacto</b></label>
                <input class="string form-control @error('contacto') is-invalid @enderror" id="contact" name="contact" type="text" value="{{ old('contact') ?? $provider->contact }}" maxlength="30" />
            </div>
        </div>

        <div class='d-flex justify-content-center pt-2'>
            <a class="button btn btn-secondary mr-5" href="{{ route('providers.index') }}" title="Regresa a la página de Gestión de Proveedores">Cancelar</a>
            <input class="btn btn-primary" type="submit" value="{{ $update ? 'Actualizar' : 'Crear' }}" />
        </div>
    </form>
</div>
