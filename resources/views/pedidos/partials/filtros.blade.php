<div class="modal fade" id="filtro_pedido">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Generar búsqueda de pedidos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <label for="agencia">Agencia <b style="color: red;">*</b></label>
            <!-- <div class="icheck-success d-inline float-sm-right">
              <input type="checkbox" name="todas" id="todas" >
              <label for="todas">Todas:</label>
            </div> -->
            <select name="id_agencia" id="id_agencia" class="form-control select2bs4" title="Seleccione la agencia la cual debe entregar el pedido" required="required" >
              <option value="todas">TODAS</option>
              @foreach($agencias as $k)
                <option value="{{$k->id}}">{{$k->nombre}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">                
            <label for="estados">Estados <b style="color: red;">*</b></label>                
            <div class="icheck-success d-inline float-sm">
              <input type="checkbox" name="todos_estados" id="todos_estados" onclick="changeEstados()" value="inactivo">
              <label for="todos_estados">Todos:</label>
            </div>
            <select name="id_estado_filtro[]" required="required" id="id_estado_filtro" class="form-control select2bs4" multiple="multiple" title="Seleccione el(los) estados de los pedidos" >
              @foreach($estados as $k)
                <option value="{{$k->id}}">{{$k->estado}}</option>
              @endforeach
            </select>
          </div>            
        </div><hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="date_from">Fecha desde <b style="color: red;">*</b></label>
              <input type="date" name="date_from" id="date_from" class="form-control form-control-sm">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="date_to">Fecha hasta <b style="color: red;">*</b></label>
              <input type="date" name="date_to" id="date_to" class="form-control form-control-sm" >
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="submit" class="btn btn-primary" id="filter"><i class="fa fa-search"></i> Buscar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->