<div class="modal fade" id="edit_estados">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Editar Estado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate>
        <div class="modal-body">
          <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <input type="hidden" name="id_estado" id="id_estado_edit" placeholder="">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="estado_edit">Estado <b style="color: red;">*</b></label>
                <input type="text" name="estado" id="estado_edit" class="form-control" required="required" placeholder="Ingrese el nombre del estado" onkeyup="this.value = this.value.toUpperCase();">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="color_edit">Color <b style="color: red;">*</b></label>
                <input type="color" name="color" id="color_edit" class="form-control" required="required" placeholder="Ingrese el color">
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-info" id="SubmitEditEstado"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->