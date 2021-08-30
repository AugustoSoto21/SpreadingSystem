<div class="modal fade" id="remove_products">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Retirar producto del Pedido con Código: <span id="mostrar_codigo"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('pedidos.remove2') }}" method="POST">
        @csrf
        <div class="modal-body">
          <h4 align="center">¿Está seguro que desea retirar este producto de la lista?</h4>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" name="id_product_remove" id="remove_id" required="required">
          <input type="hidden" name="codigo" id="codigo_pedido" required="required">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Retirar producto</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->