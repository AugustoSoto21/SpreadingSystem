@extends('layouts.app')
@section('title') Productos @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i> Productos</h1>
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
    
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <p></p>
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Productos registrados</h3>
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
              {{-- <a href="{!! route('productos.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar producto"><i class="fas fa-edit"></i> Registrar productos</a> --}}

              <a href="{!! route('productos.create') !!}" class="btn btn-info btn-sm text-white" data-tooltip="tooltip" data-placement="top" title="Crear Productos">
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
                  <th>Código</th>
                  <th>Categoría</th>
                  <th>Detalles</th>
                  <!-- <th>Marca</th>
                  <th>Modelo</th>
                  <th>Color</th> -->
                  <th>Status</th>
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
    @include('productos.partials.create')
    @include('productos.partials.edit')
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
      { data: 'categoria', name: 'categoria' },
      { data: 'detalles', name: 'detalles' },
      { data: 'status', name: 'status' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
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
      $('#edit_producto').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_producto_edit').val(data.id);
      $('#codigo_edit').text(data.codigo);
      $('#detalles_edit').val(data.detalles);
      $('#id_categoria_edit').val(data.id_categoria);
      $('#status_edit').val(data.status);
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
      detalles: $('#detalles_edit').val(),
      status: $('#status_edit').val(),
      id_categoria: $('#id_categoria_edit').val()
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
