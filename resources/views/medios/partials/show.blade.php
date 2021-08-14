<div class="modal fade" id="show_medios">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Mostrar Medio de Mercado Pago</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate id="medioFormEdit" >
        
        <div class="modal-body">
           
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="mi_medio"> Medio <b style="color: red;">*</b></label>
              <input type="text" name="medio" id="medio_show" required="required" placeholder="Ingrese el medio a modificar" disabled="disabled" onkeyup="this.value=this.value.toUpperCase();">
            </div>
            @error('mi_medio')
               <div class="alert alert-danger">{{ $messge}}
               </div>
               
            @enderror
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="Porcentaje">Porcentaje <b style="color: red;"> *</b></label>
              <input type="number" min="0" max="100" name="porcentaje" id="porcentaje_show" class="form-control" required="required" placeholder="Ingrese el monto del porcentaje" disabled="disabled" onkeyup="this.value = this.value.toUpperCase();">
            </div>
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
              <input type="number" min="0" max="100" name="interes[]" id="interes_show<?=$i?>" class="form-control"  required="required" placeholder="Ingrese el interés de la cantidad de cuota" disabled="disabled" onkeyup="this.value = this.value.toUpperCase();">
            </div>
        </div>
        @endfor
        </div><!-- cierre del modal-bady -->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-times"></i>Cerrar</button>
        </div>

      </form> 
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->