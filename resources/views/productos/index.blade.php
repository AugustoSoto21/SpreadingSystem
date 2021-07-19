@extends('layouts.app')
@section('title') Productos @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-search-location"></i> Productos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Productos</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('productos.partials.create')
    @include('productos.partials.edit')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-search-location"></i> Productos registrados</h3>
            <div class="card-tools">
              @if(search_permits('Productos','Imprimir PDF')=="Si" || search_permits('Productos','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Productos','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('productos.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Productos','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('productos.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Productos','Registrar')=="Si")
              
              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_productos" data-tooltip="tooltip" data-placement="top" title="Crear Productos" id="createNewProducto">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Productos','Ver mismo usuario')=="Si" || search_permits('Productos','Ver todos los usuarios')=="Si" || search_permits('Productos','Editar mismo usuario')=="Si" || search_permits('Productos','Editar todos los usuarios')=="Si" || search_permits('Productos','Eliminar mismo usuario')=="Si" || search_permits('Productos','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="productos_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Partido</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
          @else
          <div class="row">
            <div class="col-12">                          
              <div class="alert alert-danger alert-dismissible text-center">
                <h5><i class="icon fas fa-ban"></i> ¡Alerta!</h5>
                ACCESO RESTRINGIDO, NO POSEE PERMISO.
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@endsection
@section('scripts')
<script>
$(document).ready( function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#productos_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('productos') }}"
   },
    columns: [
      { data: 'codigo', name: 'codigo' },
      { data: 'nombre', name: 'nombre' },
      { data: 'descripcion', name: 'descripcion' },
      { data: 'modelo', name: 'modelo' },
      { data: 'marca', name: 'marca' },
      { data: 'color', name: 'color' },
      { data: 'precio_venta', name: 'precio_venta' },
      { data: 'status', name: 'status' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR ESTADOS (LEVANTAR EL MODAL) ---------------------//
$('#createNewProducto').click(function () {
  $('#productoForm').trigger("reset");
  $('#create_productos').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
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
    data: {
      codigo: $('#codigo').val(),
      nombre: $('#nombre').val(),
      descripcion: $('#descripcion').val(),
      modelo: $('#modelo').val(),
      marca: $('#marca').val(),
      color: $('#color').val(),
      precio_venta: $('#precio_venta').val(),
      status: $('#status').val(),
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
        var oTable = $('#productos_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_productos").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR ESTADO ---------------------//
$('body').on('click', '#editProducto', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "productos/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      $('#edit_productos').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_producto_edit').val(data[0].id);
      $('#codigo_edit').val(data[0].codigo);
      $('#nombre_edit').val(data[0].nombre);
      $('#descripcion_edit').val(data[0].descripcion);
      $('#modelo_edit').val(data[0].modelo);
      $('#marca_edit').val(data[0].marca);
      $('#precio_venta_edit').val(data[0].precio_venta);
      $('#status_edit').val(data[0].status);
    }
  });
});
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditProducto').click(function(e) {
  e.preventDefault();
  var id = $('#id_producto_edit').val();
  $.ajax({
    method:'PUT',
    url: "productos/"+id+"",
    data: {
      id_producto: $('#id_producto_edit').val(),
      codigo: $('#codigo_edit').val(),
      nombre: $('#nombre_edit').val(),
      descripcion: $('#descripcion_edit').val(),
      modelo: $('#modelo_edit').val(),
      marca: $('#marca_edit').val(),
      color: $('#color_edit').val(),
      precio_venta: $('#precio_venta_edit').val(),
      status: $('#status_edit').val()
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
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteProducto(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a esta producto?',
    text: "¡Esta opción no podrá deshacerse en el futuro!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Si, Eliminar!',
    cancelButtonText: 'No, Cancelar!'
  }).then((result) => {
    if (result.isConfirmed) {
      // ajax
      $.ajax({
        type:"DELETE",
        url: "productos/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#productos_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Producto no eliminada", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
