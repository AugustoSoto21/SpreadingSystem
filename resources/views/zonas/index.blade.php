@extends('layouts.app')
@section('title') Zonas @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-search-location"></i> Zonas</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Zonas</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('zonas.partials.create')
    @include('zonas.partials.edit')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-search-location"></i> Zonas registradas</h3>
            <div class="card-tools">
              @if(search_permits('Zonas','Imprimir PDF')=="Si" || search_permits('Zonas','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Zonas','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('zonas.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Zonas','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('zonas.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Zonas','Registrar')=="Si")
              {{-- <a href="{!! route('zonas.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar zona"><i class="fas fa-edit"></i> Registrar zonas</a> --}}

              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_zonas" data-tooltip="tooltip" data-placement="top" title="Crear Zonas" id="createNewZona">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Zonas','Ver mismo usuario')=="Si" || search_permits('Zonas','Ver todos los usuarios')=="Si" || search_permits('Zonas','Editar mismo usuario')=="Si" || search_permits('Zonas','Editar todos los usuarios')=="Si" || search_permits('Zonas','Eliminar mismo usuario')=="Si" || search_permits('Zonas','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="zonas" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Zona</th>
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
  $('#zonas_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('zonas') }}"
   },
    columns: [
      { data: 'zona', name: 'zona' },
      { data: 'partido', name: 'partido' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR ESTADOS (LEVANTAR EL MODAL) ---------------------//
$('#createNewZona').click(function () {
  $('#zonaForm').trigger("reset");
  $('#create_zonas').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR ESTADOS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateZona').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('zonas.store') }}",
    method: 'post',
    data: {
      zona: $('#zona').val(),
      id_partido: $('#id_partido').val(),
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
        var oTable = $('#zonas_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_zonas").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR ESTADO ---------------------//
$('body').on('click', '#editZona', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "zonas/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      $('#edit_zonas').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_zona_edit').val(data.id);
      $('#zona_edit').val(data.zona);
      $('#id_partido_edit').val(data.id_partido);
    }
  });
});
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditZona').click(function(e) {
  e.preventDefault();
  var id = $('#id_zona_edit').val();
  $.ajax({
    method:'PUT',
    url: "zonas/"+id+"",
    data: {
      id_zona: $('#id_zona_edit').val(),
      zona: $('#zona_edit').val(),
      id_partido: $('#id_partido_edit').val()
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#zonas_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_zonas").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteZona(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a esta zona?',
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
        url: "zonas/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#zonas_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Zona no eliminada", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
