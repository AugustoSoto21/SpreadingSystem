@extends('layouts.app')
@section('title') Registro de Pedido @endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><i class="nav-icon fa fa-shopping-basket"></i> Pedidos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Pedidos</a></li>
          <li class="breadcrumb-item active">Registro de Pedido</li>
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
    @include('clientes.partials.create')
    @include('productos.partials.create')
    <div class="row">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-primary card-outline">
          <form action="{{ route('productos.store') }}" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data" data-parsley-validate>
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Registro de pedido</h3>
              <div class="float-right">
                <a href="{{ route('pedidos.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>                
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
                    <label for="id_cliente">Cliente <b style="color: red;">*</b></label>
                    <select name="id_cliente" id="id_cliente" class="form-control select2">
                    </select>
                    @if(search_permits('Clientes','Registrar')=="Si")
                    <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_clientes" data-tooltip="tooltip" data-placement="top" title="Reistrar Cliente" id="createNewCliente">
                      <i class="fa fa-plus"> &nbsp;Agregar</i>
                    </a>
                    @endif
                  </div>
                  @error('id_cliente')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-8">
                  <div class="form-group">
                    <label for="id_producto">Productos <b style="color: red;">*</b></label>
                    <select name="id_producto" id="id_producto" class="form-control select2">
                    </select>
                    <!-- @if(search_permits('Productos','Registrar')=="Si")
                    <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_productos" data-tooltip="tooltip" data-placement="top" title="Reistrar Producto" id="createNewProducto">
                      <i class="fa fa-plus"> &nbsp;Agregar</i>
                    </a>
                    @endif -->
                  </div>
                  @error('id_producto')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
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
cliente_data();
producto_data();
//--CODIGO PARA CREAR CATEGORIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewCategoria').click(function () {
  $('#categoriaForm').trigger("reset");
  $('#create_categorias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});

function cliente_data() {
  $.ajax({
    type:"GET",
    url: "{{ url('buscar_clientes') }}",
    dataType: 'json',
    success: function(response){
      $('#id_cliente').empty();
      $.each(response, function(key, registro) {
        $('#id_cliente').append('<option value='+registro.id+'>'+registro.nombres+' '+registro.apellidos+' '+registro.celular+'</option>');
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de clientes.", icon:  "error"});
    }
  });
}
function producto_data() {
  $.ajax({
    type:"GET",
    url: "{{ url('buscar_productos') }}",
    dataType: 'json',
    success: function(response){
      $('#id_producto').empty();

      $.each(response, function(key, registro) {
        producto_stock(registro.id);
          
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de productos.", icon:  "error"});
    }
  });
}

$('#createNewCliente').click(function () {
  $('#clienteForm').trigger("reset");
  $('#create_clientes').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR PBX (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateCliente').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
    url: "{{ route('clientes.store') }}",
    method: 'post',
    data: {
      nombres: $('#nombres').val(),
      apellidos: $('#apellidos').val(),
      celular: $('#celular').val(),
      direccion: $('#direccion').val(),
      localidad: $('#localidad').val(),
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
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_clientes").modal('hide');
          cliente_data();
        }
      }
    }
  });
});

function producto_stock(id) {
  $.ajax({
    type:"GET",
    url: "../buscar_stock/"+id+"/producto",
    dataType: 'json',
    success: function(response){
      $.each(response, function(key, registro) {
        var total_stock;
        var total_disponible;

           if(registro.total_stock){
              total_stock=registro.total_stock;
              total_disponible=registro.total_disponible;
              $('#id_producto').append("<option value='"+registro.id+"'>"+registro.detalles+" "+registro.modelo+" "+registro.marca+" "+registro.color+" Stock: "+total_stock+" - Disponible: "+total_disponible+" </option>");
           }
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de stocks.", icon:  "error"});
    }
  });
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
