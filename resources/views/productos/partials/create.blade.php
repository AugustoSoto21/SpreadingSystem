<div class="modal fade" id="create_productos">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="nav-icon fa fa-shopping-basket"></i> Crear Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" data-parsley-validate name="productoForm" id="productoForm">
        
        <div class="modal-body">
          <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
          <div class="row">
            <div class="col-sm-4">
                  <div class="form-group">
                    <label for="id_categoria">Categoría <b style="color: red;">*</b></label>
                    <select name="id_categoria" id="id_categoria" class="form-control select2">
                      @foreach($categorias as $c)
                        <option value="{{$c->id}}">{{$c->categoria}}</option>
                      @endforeach
                    </select>
                    @if(search_permits('Categorias','Registrar')=="Si")
                    <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_categorias" data-tooltip="tooltip" data-placement="top" title="Crear Categorias" id="createNewCategoria">
                      <i class="fa fa-plus"> &nbsp;Agregar</i>
                    </a>
                    @endif
                  </div>
                  @error('id_categoria')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="detalles">Detalles <b style="color: red;">*</b></label>
              <input type="text" name="detalles" id="detalles" class="form-control" required="required" placeholder="Ingrese los detalles del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('detalles')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="modelo">Modelo <b style="color: red;">*</b></label>
                <input type="text" name="modelo" id="modelo" class="form-control" required="required" placeholder="Ingrese el modelo del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('modelo')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="marca">Marca </label>
              <input type="text" name="marca" id="marca" class="form-control" placeholder="Ingrese la marca del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('marca')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="color">Color <b style="color: red;">*</b></label>
              <input type="text" name="color" id="color" class="form-control" required="required" placeholder="Ingrese el color del producto" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              @error('color')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" id="SubmitCreateProducto" class="btn btn-info"><i class="fa fa-save"></i> Registrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->