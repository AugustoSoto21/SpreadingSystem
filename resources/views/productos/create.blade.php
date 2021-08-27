@extends('layouts.app')
@section('title') Registro de producto @endsection
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
          <li class="breadcrumb-item active">Registro de producto</li>
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
          <form action="{{ route('productos.store') }}" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data" data-parsley-validate>
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Registro de producto</h3>
              <div class="float-right">
                <a href="{{ route('productos.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>                
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar registro</button>
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
                    <select name="id_categoria" id="id_categoria" class="form-control select2">
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
                    <input type="text" name="detalles" id="detalles" class="form-control" required="required" placeholder="Ingrese los detalles del producto" onkeyup="this.value = this.value.toUpperCase();">
                  </div>
                  @error('detalles')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="status">Status <b style="color: red;">*</b></label>
                    <select name="status" id="status" class="form-control">
                      <option value="Activo">Activo</option>
                      <option value="Inactivo">Inactivo</option>
                    </select>
                  </div>
                </div>  
              </div>
              <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="marca">Marca </label>
                        <input type="text" name="marca" id="marca" class="form-control" placeholder="Ingrese la marca del producto" onkeyup="this.value = this.value.toUpperCase();">
                      </div>
                      @error('marca')
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
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="color">Color <b style="color: red;">*</b></label>
                        <input type="text" name="color" id="color" class="form-control" required="required" placeholder="Ingrese el color del producto" onkeyup="this.value = this.value.toUpperCase();">
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
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="stock">Stock <b style="color: red;">*</b></label>
                        <input type="number" name="stock_s" id="stock_s" class="form-control stocks" required="required" min="0">
                      </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="color">Stock Mínimo </label>
                        <input type="number" name="stock_min_s" id="stock_min_s" class="form-control stocks_min" min="0">
                      </div>
                  </div>
                </div>

              @if(count($agencias) > 0)
                <div class="row">
                  <div class="col-sm-12">
                    <label for="titulo">Agencias con Almacén</label>
                  </div>
                </div>
              @endif
              @foreach($agencias as $k)
                <div class="row">
                  <div class="col-sm-4">
                    <label for="nombre_agencia" style="color: blue;">{{ $k->nombre}}</label>
                      <input type="hidden" name="id_agencia[]" id="id_agencia" value="{{ $k->id }}">
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="stock">Stock <b style="color: red;">*</b></label>
                        <input type="number" name="stock[]" id="stock" class="form-control" required="required" min="0">
                      </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                        <label for="color">Stock Mínimo </label>
                        <input type="number" name="stock_min[]" id="stock_min" class="form-control" min="0">
                      </div>
                  </div>
                </div>
              @endforeach
              <div class="row">
                <div class="col-sm-12">
                  <label for="imagenes1" >Imágenes <b style="color: red;">*</b></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="imagenes" name="imagenes[]" required="true" accept="image/jpeg,image/jpg,image/png"  multiple="multiple">
                      <label class="custom-file-label" for="imagenes">Seleccionar archivo...</label>
                    </div>
                  </div>
                </div>
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
$(document).ready(function () {
  bsCustomFileInput.init();
});
categoria_data();
//--CODIGO PARA CREAR CATEGORIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewCategoria').click(function () {
  $('#categoriaForm').trigger("reset");
  $('#create_categorias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
function categoria_data() {
  $.ajax({
    type:"GET",
    url: "{{ url('buscar_categorias') }}",
    dataType: 'json',
    success: function(response){
      $('#id_categoria').empty();
      $.each(response, function(key, registro) {
        $('#id_categoria').append('<option value='+registro.id+'>'+registro.categoria+'</option>');
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de medio publicitario.", icon:  "error"});
    }
  });
}
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
          categoria_data();
        }
      }
    }
  });
});

</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
