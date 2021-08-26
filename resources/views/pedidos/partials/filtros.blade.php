<div class="modal fade" id="filtro_pedido">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Generar búsqueda de pedidos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="#" method="POST" data-parsley-validate name="filtroForm" id="filtroForm">
        <div class="modal-body">
          <div class="row">
              <div class="col-4">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" required="required" id="fecha" class="form-control" title="Seleccione la fecha en la cual se debe entregar el pedido" value="{{date('Y-m-d')}}">
              </div>
              <div class="col-4">
                
                  <label for="agencia">Agencia</label>
                
                <div class="icheck-success d-inline float-sm-right">
                        <input type="checkbox" name="todas" id="todas" >
                        <label for="todas">Todas:</label>
                </div>
                <select name="id_agencia" id="id_agencia" class="form-control select2bs4" title="Seleccione la agencia la cual debe entregar el pedido" required="required" >
                  @foreach($agencias as $k)
                    <option value="{{$k->id}}">{{$k->nombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-4">
                
                  <label for="estados">Estados</label>
                
                <div class="icheck-success d-inline float-sm-right">
                        <input type="checkbox" name="todos" id="todos" >
                        <label for="todos">Todos:</label>
                </div>
                <select name="id_estado[]" required="required" id="id_estado" class="form-control select2bs4" multiple="multiple" title="Seleccione el(los) estados de los pedidos" >
                  @foreach($estados as $k)
                    <option value="{{$k->id}}">{{$k->estado}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-primary" id="filter"><i class="fa fa-search"></i> Buscar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->