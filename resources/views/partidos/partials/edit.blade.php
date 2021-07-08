<div class="modal fade" id="edit_partidos">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Editar Partido</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('partidos.update',1) }}" method="POST" data-parsley-validate>
        @csrf
        @method('PUT')
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <input type="hidden" name="id_partido" value="" id="id_partido" placeholder="">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="partido">Partido <b style="color: red;">*</b></label>
                <input type="text" name="partido" id="partido_edit" class="form-control" required="required" placeholder="Ingrese el nombre del partido" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('partido')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->