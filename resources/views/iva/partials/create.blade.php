<div class="modal fade" id="create_iva">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Crear Iva</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate  name="ivaForm" id="ivaForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.<br>Nota: El monto que será registrado a continuación será el monto <b>Activo</b> para uso del sistema, de manera que el que actualmente se encuetra activo pasará a <b>Inactivo</b></small></p>
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <label for="iva">Iva <b style="color: red;">*</b></label>
                <input type="number" min="0" max="100" name="iva" id="iva" class="form-control" required="required" placeholder="Ingrese el valor en porcentaje del iva" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('iva')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitCreateIva" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->