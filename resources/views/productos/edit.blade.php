@extends('layouts.app')
@section('title') Editar producto @endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><i class="nav-icon fa fa-shopping-basket"></i> Productos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
          <li class="breadcrumb-item active">Editar producto</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    @include('categorias.partials.create')
    <div class="row">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-primary card-outline">
          <form action="" class="form-horizontal" method="PUT" autocomplete="off" enctype="Multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Editar producto: <span id="codigo_edit">{{ $productos->codigo }}</span></h3>
              <div class="float-right">
                <a href="{{ route('productos.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>                
                <button type="submit" class="btn btn-primary btn-sm" id="SubmitCreateProducto"><i class="fa fa-save"></i> Guardar registro</button>
              </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;" id="message_error">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="id_categoria">Categoría <b style="color: red;">*</b></label>
                    <select name="id_categoria" id="id_categoria_edit" class="form-control select2">
                      @foreach($categorias as $k)
                      <option value="{{ $k->id }}" @if($productos->id_categoria==$k->id) selected="selected" @endif >{{ $k->categoria }}</option>
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
                <div class="col-sm-5">
                  <div class="form-group">
                    <label for="detalles">Detalles <b style="color: red;">*</b></label>
                    <input type="text" name="detalles" id="detalles_edit" class="form-control" value="{{ $productos->detalles }}" required="required" placeholder="Ingrese los detalles del producto" onkeyup="this.value = this.value.toUpperCase();">
                  </div>
                  @error('detalles')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="status">Status <b style="color: red;">*</b></label>
                    <select name="status" id="status_edit" class="form-control select2">
                      <option value="Activo" @if($productos->status=="Si") selected="selected" @endif >Activo</option>
                      <option value="Inactivo" @if($productos->status=="No") selected="selected" @endif >Inactivo</option>
                    </select>
                  </div>
                </div>  
              </div>
              <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="marca">Marca </label>
                        <input type="text" name="marca" id="marca_edit" class="form-control" value="{{ $productos->marca }}" placeholder="Ingrese la marca del producto" onkeyup="this.value = this.value.toUpperCase();">
                      </div>
                      @error('marca')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="modelo">Modelo <b style="color: red;">*</b></label>
                        <input type="text" name="modelo" id="modelo_edit" class="form-control" value="{{ $productos->modelo }}" required="required" placeholder="Ingrese el modelo del producto" onkeyup="this.value = this.value.toUpperCase();">
                      </div>
                      @error('modelo')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="color">Color <b style="color: red;">*</b></label>
                        <input type="text" name="color" id="color_edit" class="form-control" value="{{ $productos->color }}" required="required" placeholder="Ingrese el color del producto" onkeyup="this.value = this.value.toUpperCase();">
                      </div>
                      @error('color')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-4">
                    <label for="nombre_agencia" style="color: blue;"> INVENTARIO SPREADING</label>
                  </div>
                  @foreach($productos->inventario as $k)
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="stock">Stock <b style="color: red;">*</b></label>
                        <input type="number" name="stock_s" value="{{ $k->stock }}" id="stock_s" class="form-control" required="required" min="0">
                      </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="color">Stock Mínimo </label>
                        <input type="number" name="stock_min_s" id="stock_min_s" value="{{ $k->stock_min }}" class="form-control" min="0">
                      </div>
                  </div>
                </div>
                @endforeach

              @if(count($agencias) > 0)
                <div class="row">
                  <div class="col-sm-12">
                    <label for="titulo">Agencias con Almacén</label>
                  </div>
                </div>
              @endif
              @foreach($agencias as $k)
              @php  $almacen=productos_almacen($k->id,$productos->id); @endphp
                <div class="row">
                  <div class="col-sm-4">
                    <label for="nombre_agencia" style="color: blue;">{{ $k->nombre}}</label>
                      <input type="hidden" name="id_agencia" id="id_agencia" value="{{ $k->id }}">
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="stock">Stock <b style="color: red;">*</b></label>
                        <input type="number" name="stock[]" id="stock" class="form-control" required="required" min="0" value="{{ (int)$almacen[0] }}">
                      </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="color">Stock Mínimo </label>
                        <input type="number" name="stock_min[]"  id="stock_min" class="form-control" min="0" value="{{ (int)$almacen[1] }}">
                      </div>
                  </div>
                </div>
              @endforeach
              <div class="row">
                <div class="col-sm-12">
                  <label for="imagenes1" >Imágenes <b style="color: red;">*</b></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="imagenes" name="imagenes[]" accept="image/jpeg,image/jpg,image/png"  multiple="multiple">
                      <label class="custom-file-label" for="imagenes">Seleccionar archivo...</label>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row">
                @foreach($productos->imagenes as $k)
                  <div class="col-md-4">
                    <div class="position-relative">
                      <img src="{{ asset($k->url)}}" alt="Photo 1" class="img-fluid">
                      <div class="ribbon-wrapper ribbon-lg">
                        <div class="ribbon bg-success text-lg">
                          IMAGEN
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <!-- /.card-body -->
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('scripts')
<script type="text/javascript">
//--CODIGO PARA EDITAR ESTADO ---------------------//
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditProducto').click(function(e) {
  e.preventDefault();
  var id = $('#id_producto_edit').val();
  $.ajax({
    method:'PUT',
    url: "productos/"+id+"",
    data: {
      id_producto: $('#id_producto_edit').val(),
      detalles: $('#detalles_edit').val(),
      status: $('#status_edit').val(),
      marca: $('#marca_edit').val(),
      modelo: $('#modelo_edit').val(),
      color: $('#color_edit').val(),
      stock_s: $('#stock_s_edit').val(),
      stock_min_s: $('#stock_min_s_edit').val(),
      
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#productos_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_productos").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA CREAR CATEGORIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewCategoria').click(function () {
  $('#categoriaForm').trigger("reset");
  $('#create_categorias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR CATEGORIAS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateCategoria').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('categorias.store') }}",
    method: 'post',
    data: {
      categoria: $('#categoria').val()
    },
    success: function(result) {
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        var oTable = $('#categorias_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_categorias").modal('hide');
        }
      }
    }
  });
});
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
