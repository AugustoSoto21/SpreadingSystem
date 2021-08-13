<div class="modal fade" id="edit_zonas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Editar Zona</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate>
        <div class="modal-body">
           <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
           <input type="hidden" name="id_zona" value="" id="id_zona_edit" placeholder="" />
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="mi_zona"> Zona <b style="color: red;">*</b></label>
              <input type="text" name="zona" id="zona_edit" required="required" placeholder="Ingrese la zona a modificar" onkeyup="this.value=this.value.toUpperCase();">
            </div>
            @error('mi_zona')
               <div class="alert alert-danger">{{ $messge}}
                 
               </div>
               
            @enderror
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="mi_partido">Partido <b style="color: red;"> *</b></label>
              <select name="id_partido" id="id_partido_edit" class="form-control select2">
                @foreach($partidos as $key)
                <option value="{{ $key->id }}">{{ $key->partido }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        </div><!-- cierre el modal-body -->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-times"></i>Cerrar</button>
          <button type="submit" id="SubmitEditZona" class="btn btn-info"><i class="fa fa-save"></i>Guardar</button>
        </div>
      </form> 
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->