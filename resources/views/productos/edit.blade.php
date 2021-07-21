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
    <div class="row">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-primary card-outline">
          <form action="" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data">
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Editar producto</h3>
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
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="codigo">Código <b style="color: red;">*</b></label>
                    <input type="text" name="codigo" id="codigo" class="form-control" required="required" placeholder="Ingrese el código del producto" onkeyup="this.value = this.value.toUpperCase();" disabled="true" value="{!!$productos->codigo!!}">
                  </div>
                  @error('codigo')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nombre">Nombre <b style="color: red;">*</b></label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required="required" placeholder="Ingrese el nombre del producto" onkeyup="this.value = this.value.toUpperCase();" value="{!!$productos->nombre!!}">
                  </div>
                  @error('nombre')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="descripcion">Descripción <b style="color: red;">*</b></label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" required="required" placeholder="Ingrese la descripcion del producto" onkeyup="this.value = this.value.toUpperCase();" value="{!!$productos->descripcion!!}">
                  </div>
                  @error('descripcion')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="modelo">Modelo <b style="color: red;">*</b></label>
                    <input type="text" name="modelo" id="modelo" class="form-control" required="required" placeholder="Ingrese el modelo del producto" onkeyup="this.value = this.value.toUpperCase();" value="{!!$productos->modelo!!}">
                  </div>
                  @error('modelo')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="marca">Marca <b style="color: red;">*</b></label>
                    <input type="text" name="marca" id="marca" class="form-control" required="required" placeholder="Ingrese la marca del producto" onkeyup="this.value = this.value.toUpperCase();" value="{!!$productos->marca!!}">
                  </div>
                  @error('marca')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="color">Color <b style="color: red;">*</b></label>
                    <input type="text" name="color" id="color" class="form-control" required="required" placeholder="Ingrese el color del producto" onkeyup="this.value = this.value.toUpperCase();" value="{!!$productos->color!!}">
                  </div>
                  @error('color')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="precio_venta">Precio de Venta <b style="color: red;">*</b></label>
                    <input type="text" name="precio_venta" id="precio_venta" class="form-control" required="required" placeholder="Ingrese el precio de venta del producto" onkeyup="this.value = this.value.toUpperCase();" value="{!!$productos->precio_venta!!}">
                  </div>
                  @error('precio_venta')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="status">Status <b style="color: red;">*</b></label>
                    <select name="status" id="status" class="form-control select2">
                      <option value="Activo" @if($productos->status=="Activo") selected @endif>Activo</option>
                      <option value="Inactivo" @if($productos->status=="Inactivo") selected @endif>Inactivo</option>
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
      nombre: $('#nombre').val(),
      descripcion: $('#descripcion').val(),
      modelo: $('#modelo').val(),
      marca: $('#marca').val(),
      color: $('#color').val(),
      precio_venta: $('#precio_venta').val(),
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
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
