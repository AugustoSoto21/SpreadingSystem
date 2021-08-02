<div class="modal fade" id="edit_historials">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Editar Historial de Stocks</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate>
        <div class="modal-body">
          <input type="hidden" name="id_historial" id="id_historial_edit" placeholder="">
          <p align="center" style="font-weight: bold;">¿Está seguro que desea actualizar el historial con la siguiente información?</p>
          <div class="row">
            <div class="col-sm-6">
              <b>Fecha:</b> <span id="fecha_edit"></span>              
            </div>
            <div class="col-sm-6">
              <b>Agencia:</b> <span id="agencia_edit"></span>              
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <b>Locker:</b> <span id="locker_edit"></span>              
            </div>
            <div class="col-sm-6">
              <b>Producto:</b> <span id="producto_edit"></span>              
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <b>Cantidad:</b> <span id="cantidad_edit"></span>
            </div>            
          </div>
          <div class="row">
            <div class="col-sm-6">
              <input type="hidden" name="fecha" id="fecha_e">
              <input type="hidden" name="id_agencia" id="id_agencia_e">
              <input type="hidden" name="locker" id="locker_e">
              <input type="hidden" name="id_producto" id="id_producto_e">
              <input type="hidden" name="cantidad" id="cantidad_e">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-info" id="SubmitEditHistorial"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->