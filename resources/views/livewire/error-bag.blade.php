@if (isset($errors) && $errors->any())
    <div class="container-fluid mt-3">
        <div class="d-flex alert alert-danger shadow-sm" role="alert">
            <div class="align-self-center">
                <img width="25px" src="{{ asset('images/icons8-general-warning-sign-48.png') }}" alt="Warning" class="">
            </div>

            <ul class="d-flex flex-column align-self-center list-unstyled ml-4 mb-0">
                @foreach ($errors->all() as $error)
                    <span class="text-danger"><li>- {{ $error }}</li></span>
                @endforeach
            </ul>

            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
