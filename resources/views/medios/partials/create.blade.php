<div class="modal fade" id="create_medios">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Crear Medio</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form action="#" method="POST" data-parsley-validate name="medioForm" id="medioForm">
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.<br> Nota: el medio que será registrado quedará asignado automáticamente al iva <b>Activo</b> y el medio quedará <b>Activo</b> para uso del sistema, de no encontrarse un monto de iva activo, no podrá completarse el registro</small></p>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="medio">Medio <b style="color: red;">*</b></label>
                <input type="text" name="medio" id="medio" class="form-control" required="required" placeholder="Ingrese el nombre del medio" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('medio')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                
                <label for="porcentaje">Porcentaje <b style="color: red;">*</b></label>
                <input type="number" min="0" value="0" max="100" name="porcentaje" id="porcentaje" class="form-control" required="required" placeholder="Ingrese el monto del porcentaje" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('porcentaje')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label for="cuotas">Interés de Cuotas <b style="color: red;">*</b></label>
           
          </div>
        </div>
        @for($i=1; $i <= 12; $i=$i+3)
        @php if($i==4) $i--; @endphp
        <div class="row">
            <div class="col-sm-4">
              <label for="interes">Cantidad de Cuotas: {{$i}}</label>
            </div>
            <div class="col-sm-4">
              <input type="number" min="0" value="0" max="100" name="interes[]" id="interes<?=$i?>" class="form-control" required="required" placeholder="Ingrese el interés de la cantidad de cuota" onkeyup="this.value = this.value.toUpperCase();">
            </div>
        </div>
        @endfor
        </div><!-- cierre del modal-bady -->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          @if($iva_activo > 0)
          <button type="submit" id="SubmitCreateMedio" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
          @endif
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->