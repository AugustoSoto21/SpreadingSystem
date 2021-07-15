@extends('layouts.app')
@section('title') Fuentes @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-share-alt-square"></i> Fuentes</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Fuentes</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('fuentes.partials.create')
    @include('fuentes.partials.edit')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-share-alt-square"></i> Fuentes registradas</h3>
            <div class="card-tools">
              @if(search_permits('Fuentes','Imprimir PDF')=="Si" || search_permits('Fuentes','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Fuentes','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('fuentes.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Fuentes','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('fuentes.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Fuentes','Registrar')=="Si")
              {{-- <a href="{!! route('fuentes.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar fuente"><i class="fas fa-edit"></i> Registrar fuentes</a> --}}

              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_fuentes" data-tooltip="tooltip" data-placement="top" title="Crear Fuentes" id="createNewFuentes">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
           @if(search_permits('Fuentes','Ver mismo usuario')=="Si" || search_permits('Fuentes','Ver todos los usuarios')=="Si" || search_permits('Fuentes','Editar mismo usuario')=="Si" || search_permits('Fuentes','Editar todos los usuarios')=="Si" || search_permits('Fuentes','Eliminar mismo usuario')=="Si" || search_permits('Fuentes','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="fuentes" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Fuente</th>
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
  $('#fuentes_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('fuentes') }}"
   },
    columns: [
      { data: 'fuente', name: 'fuente' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR ESTADOS (LEVANTAR EL MODAL) ---------------------//
$('#createNewFuente').click(function () {
  $('#fuenteForm').trigger("reset");
  $('#create_fuentes').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR ESTADOS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateFuente').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('fuentes.store') }}",
    method: 'post',
    data: {
      fuente: $('#fuente').val()
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
        var oTable = $('#fuentes_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_fuentes").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR ESTADO ---------------------//
$('body').on('click', '#editFuente', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "fuentes/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      $('#edit_fuentes').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_fuente_edit').val(data.id);
      $('#fuente_edit').val(data.fuente);
    }
  });
});
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditFuente').click(function(e) {
  e.preventDefault();
  var id = $('#id_fuente_edit').val();
  $.ajax({
    method:'PUT',
    url: "fuentes/"+id+"",
    data: {
      id_fuente: $('#id_fuente_edit').val(),
      fuente: $('#fuente_edit').val()
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#fuentes_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_fuentes").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteFuente(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a este fuente?',
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
        url: "fuentes/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#fuentes_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Fuente no eliminada", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
