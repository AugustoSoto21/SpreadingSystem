<div class="modal fade" id="remito_pedido">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Remito</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <b>Fecha: </b><span id="fecha"></span><br>
            <b>Cliente: </b><span id="cliente"></span><br>
          </div>
          <div class="col-md-6">                
            <b>Dirección: </b><span id="direccion"></span><br>
            <b>Celular: </b><span id="celular"></span> <br>            
          </div>            
        </div>
        <div class="row">
          <div class="col-md-12 table-responsive">
              <table class="table table-striped table-sm" style="text-align: center; font-size: 14px;">
                <thead>
                <tr>
                  <th>Cantidad</th>
                  <th>Producto</th>
                  <th>Valor unitario</th>
                  <th >Total P/P</th>
                </tr>
                </thead>
                <tbody id="invoice_remito">
                </tbody>
              </table>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm">
                  <tr align="right">
                    <td>Descuento:</td>
                    <td><span id="descuento"></span></td>
                  </tr>
                  <tr align="right">
                    <td>Iva:</td><td><span id="iva"></span></td>
                  </tr>
                  <tr align="right">
                    <td>Recargo:</td><td><span id="recargo"></span></td>
                  </tr>
                  <tr align="right">
                    <td>Total:</td><td><span id="total"></span></td>
                  </tr>
                  
                </table>
            </div>
          </div>
        </div><hr>
        <div class="row"><div class="col-md-12"><h4 align="center"><b>Horarios</b></h4></div></div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm" id="mostrar_horarios" style="text-align: center;">
                  <tr>
                    <th>Horario:</th>
                    <th>Hora Desde:</th>
                    <th>Hora Hasta:</th>
                    <th>Dirección:</th>
                  </tr>                  
                </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->