<div class="modal fade" id="deleteModal-{{ $member->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="{{ asset('images/icons8-general-warning-sign-48.png') }}" alt="Eliminar" class="mr-5">

        <h5 class="modal-title mt-2" id="deleteModalCenterTitle">Eliminar Socio</h5>

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body mt-2">
        <p>¿Está seguro que desea eliminar el Socio? Todos los datos de<br/>
        <b>{{ $member->fullName() }}</b> <br/>
        serán eliminados de la Base de Datos.<br /></p>
      </div>

      <div class="modal-footer">
        <div class='d-flex justify-content-center'>
          <a href="#" class="button btn btn-secondary mr-5" data-bs-dismiss="modal">
            Cancelar
          </a>

          <a href="#" class="button btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-member-{{ $member->id }}-form').submit();">
            Eliminar
          </a>
          <form id="delete-member-{{ $member->id }}-form" action="{{ route('members.destroy', $member) }}" method="POST" class="hidden">
              @method("DELETE")
              @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
