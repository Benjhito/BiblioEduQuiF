<h5 class="text-center"><b>Socios | Gestión de Socios</b></h5>

<div class="d-flex justify-content-center">
    <form class="w-50 bg-light border border-dark rounded p-3 mb-3 mx-5" method="POST" action="{{ $route }}">
        @csrf
        @if($update)
            @method("PUT")
        @endif

        <h5 class="text-center"><b>{{ $update ? 'Editar Socio' : 'Nuevo Socio' }}</b></h5>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="code" id="code__label"><b>Código</b></label>
                <input class="string form-control" id="code" name="code" type="text" value="{{ $member->code }}" readonly="on" />
            </div>

            <div class="form-group col-12 col-md-5">
                <label class="col-form-label text-secondary" for="last_name" id="last_name__label"><b>Apellidos</b></label>
                <input class="string form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" type="text" value="{{ old('last_name') ?? $member->last_name }}" maxlength="30" autofocus="on" />

            </div>

            <div class="form-group col-12 col-md-5">
                <label class="col-form-label text-secondary" for="first_name" id="first_name__label"><b>Nombres</b></label>
                <input class="string form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" type="text" value="{{ old('first_name') ?? $member->first_name }}" maxlength="30" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-3">
                <label class="col-form-label text-secondary" for="doc_number" id="doc_number__label"><b>DNI</b></label>
                <input class="string form-control @error('doc_number') is-invalid @enderror" id="doc_number" name="doc_number" type="text" value="{{ old('doc_number') ?? $member->doc_number }}" maxlength="13" />
            </div>

            <div class="form-group col-12 col-md-9">
                <label class="col-form-label text-secondary" for="address" id="address__label"><b>Domicilio</b></label>
                <input class="string form-control @error('address') is-invalid @enderror" id="address" name="address" type="text" value="{{ old('address') ?? $member->address }}" maxlength="50" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="postcode" id="postcode__label"><b>Cód.Postal</b></label>
                <input class="string form-control @error('postcode') is-invalid @enderror" id="postcode" name="postcode" type="text" value="{{ old('postcode') ?? $member->postcode }}" maxlength="8" />
            </div>

            <div class="form-group col-12 col-md-7">
                <label class="col-form-label text-secondary" for="locality" id="locality__label"><b>Localidad</b></label>
                <input class="string form-control @error('locality') is-invalid @enderror" id="locality" name="locality" type="text" value="{{ old('locality') ?? $member->locality }}" maxlength="40" />
            </div>

            <div class="form-group col-12 col-md-3">
                <label class="col-form-label text-secondary" for="mobile" id="mobile__label"><b>Tel. Móvil</b></label>
                <input class="string form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" type="text" value="{{ old('mobile') ?? $member->mobile }}" maxlength="20" />

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-8">
                <label class="col-form-label text-secondary" for="email" id="email__label"><b>Email</b></label>
                <input class="string form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') ?? $member->email }}" />
            </div>

            <div class="form-group col-12 col-md-4">
                <label class="col-form-label text-secondary" for="adm_date" id="adm_date__label"><b>Fecha de Admisión</b></label>
                <input class="form-control @error('adm_date') is-invalid @enderror" id="adm_date" name="adm_date" type="date" value="{{ old('adm_date') ?? ($member->adm_date ? $member->adm_date->format('Y-m-d') : '') }}" />
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-2">
                <label class="col-form-label text-secondary" for="status" id="status__label"><b>Estado</b></label>
                <select class="form-control generic-widget" id="status" name="status">
                    <option value="Activo" {{ (old('status') ?? $member->status) == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Suspendido" {{ (old('status') ?? $member->status) == 'Suspendido' ? 'selected' : '' }}>Suspendido</option>
                </select>
            </div>

            <div class="form-group col-12 col-md-10">
                <label class="col-form-label text-secondary" for="notes" id="notes__label"><b>Observaciones</b></label>
                <input class="string form-control @error('notes') is-invalid @enderror" id="notes" name="notes" type="notes" value="{{ old('notes') ?? $member->notes }}" maxlength="50" />
            </div>
        </div>

        <div class='d-flex justify-content-center pt-2'>
            <a class="button btn btn-secondary mr-5" href="{{ route('members.index') }}" title="Regresa a la página de Gestión de Socios">Cancelar</a>
            <input class="btn btn-primary" type="submit" value="{{ $update ? 'Actualizar' : 'Crear' }}" />
        </div>
    </form>
</div>
