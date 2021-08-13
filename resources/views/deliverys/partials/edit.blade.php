<div class="modal fade" id="edit_deliverys">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Editar Delivery</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate >
        
        <div class="modal-body">
           <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
           <input type="hidden" name="id_delivery" value="" id="id_delivery_edit" placeholder="" />
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="mi_delivery"> Delivery <b style="color: red;">*</b></label>
              <input type="text" name="delivery" id="delivery_edit" required="required" placeholder="Ingrese la delivery a modificar" onkeyup="this.value=this.value.toUpperCase();">
            </div>
            @error('mi_delivery')
               <div class="alert alert-danger">{{ $messge}}
                 
               </div>
               
            @enderror
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="mi_agencia">Agencia <b style="color: red;"> *</b></label>
              <select name="id_agencia" id="id_agencia_edit" class="form-control select2">
                @foreach($agencias as $key)
                <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        </div><!-- cierre del modal-body -->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-times"></i>Cerrar</button>
          <button type="submit" id="SubmitEditDelivery" class="btn btn-info"><i class="fa fa-save"></i>Guardar</button>
        </div>
      </form> 
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->