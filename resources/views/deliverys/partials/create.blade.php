<div class="modal fade" id="create_deliverys">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Crear Delivery</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form action="#" method="POST" data-parsley-validate name="deliveryForm" id="deliveryForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="delivery">Delivery <b style="color: red;">*</b></label>
                <input type="text" name="delivery" id="delivery" class="form-control" required="required" placeholder="Ingrese el nombre del delivery" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('delivery')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                
                <label for="id_agencia">Agencia <b style="color: red;">*</b></label>
                <select name="id_agencia" id="id_agencia" class="form-control select2">
                  @foreach($agencias as $p)
                  <option value="{!! $p->id !!}">{!! $p->nombre !!}</option>
                  @endforeach
                </select>

              </div>
              @error('id_agencia')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitCreateDelivery" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->