<div class="modal fade" id="delete_zonas">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-clipboard-list"></i> Eliminar Zona</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('zonas.destroy', 1) }}" method="POST" data-parsley-validate>
        @csrf
        @method('DELETE')
        <div class="modal-body">
          <h4 align="center">¿Está seguro que desea eliminar esta zona, esta opción no podrá deshacerse en el futuro?</h4>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" name="id_zona" id="delete_id_zona" required="required">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar registro</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->