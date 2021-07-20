<div class="modal fade" id="edit_producto">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Editar Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate >
        
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <input type="hidden" name="id_producto" id="id_producto_edit">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="codigo">Código <b style="color: red;">*</b></label>
                <input type="text" name="codigo" id="codigo_edit" class="form-control" required="required" placeholder="Ingrese el código del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('codigo')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nombre">Nombre <b style="color: red;">*</b></label>
              <input type="text" name="nombre" id="nombre_edit" class="form-control" required="required" placeholder="Ingrese el nombre del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="descripcion">Descripción <b style="color: red;">*</b></label>
              <input type="text" name="descripcion" id="descripcion_edit" class="form-control" required="required" placeholder="Ingrese la descripcion del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('descripcion')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="modelo">Modelo <b style="color: red;">*</b></label>
                <input type="text" name="modelo" id="modelo_edit" class="form-control" required="required" placeholder="Ingrese el modelo del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('modelo')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="marca">Marca <b style="color: red;">*</b></label>
              <input type="text" name="marca" id="marca_edit" class="form-control" required="required" placeholder="Ingrese la marca del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('marca')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="color">Color <b style="color: red;">*</b></label>
              <input type="text" name="color" id="color_edit" class="form-control" required="required" placeholder="Ingrese el color del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('color')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="precio_venta">Precio de Venta <b style="color: red;">*</b></label>
              <input type="text" name="precio_venta" id="precio_venta_edit" class="form-control" required="required" placeholder="Ingrese el precio de venta del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('precio_venta')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="status">Status <b style="color: red;">*</b></label>
              <select name="status" id="status_edit" class="form-control select2">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
              @error('precio_venta')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitEditProducto" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->