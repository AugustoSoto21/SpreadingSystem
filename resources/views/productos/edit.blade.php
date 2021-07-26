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
          <form action="" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data">
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Editar producto: <span id="codigo_edit"></span></h3>
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
                      <option value="{{ $k->id }}">{{ $k->categoria }}</option>
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
                    <input type="text" name="detalles" id="detalles_edit" class="form-control" required="required" placeholder="Ingrese los detalles del producto" onkeyup="this.value = this.value.toUpperCase();">
                  </div>
                  @error('detalles')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="status">Status <b style="color: red;">*</b></label>
                    <select name="status" id="status_edit" class="form-control select2">
                      <option value="Activo">Activo</option>
                      <option value="Inactivo">Inactivo</option>
                    </select>
                  </div>
                </div>  
              </div>
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
              <div class="row">
                @foreach($productos->imagenes as $k)
                  <div class="col-md-4">
                    <div class="position-relative">
                      <img src="{!!$k->url!!}" alt="Photo 1" class="img-fluid">
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
//--CODIGO PARA CREAR ESTADOS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateProducto').click(function(e) {  
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('productos.store') }}",
    method: 'post',
    enctype: 'multipart/form-data',
    data: {
      codigo: $('#codigo').val(),
      detalles: $('#detalles').val(),
      id_categoria: $('#id_categoria').val(),
      status: $('#status').val(),
      imagenes: $('#imagenes').val()
    },
    success: function(result) {
      console.log(result.errors);
      if(result.errors) {
        $('#message_error').html('');
        $.each(result.errors, function(key, value) {
          $('#message_error').show();
          $('#message_error').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('#message_error').hide();
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
      }
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
