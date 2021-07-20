@extends('layouts.app')
@section('title') Agencias @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-home"></i> Agencias</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Agencias</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('agencias.partials.create')
    @include('agencias.partials.edit')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-home"></i> Agencias registradas</h3>
            <div class="card-tools">
              @if(search_permits('Agencias','Imprimir PDF')=="Si" || search_permits('Agencias','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Agencias','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('agencias.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Agencias','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('agencias.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Agencias','Registrar')=="Si")
              {{-- <a href="{!! route('agencias.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar agencia"><i class="fas fa-edit"></i> Registrar agencias</a> --}}
              
              <a class="btn btn-info btn-sm text-white" data-tooltip="tooltip" data-placement="top" title="Crear Agencias" id="createNewAgencia">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Agencias','Ver mismo usuario')=="Si" || search_permits('Agencias','Ver todos los usuarios')=="Si" || search_permits('Agencias','Editar mismo usuario')=="Si" || search_permits('Agencias','Editar todos los usuarios')=="Si" || search_permits('Agencias','Eliminar mismo usuario')=="Si" || search_permits('Agencias','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="agencias_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Agencia</th>
                  <th>Almacen</th>
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
  $('#agencias_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('agencias') }}"
   },
    columns: [
      { data: 'nombre', name: 'nombre' },
      { data: 'almacen', name: 'almacen' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});

//--CODIGO PARA CREAR AGENCIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewAgencia').click(function () {
  $('#agenciaForm').trigger("reset");
  $('#create_agencias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR AGENCIAS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateAgencia').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('agencias.store') }}",
    method: 'post',
    data: {
      nombre: $('#nombre').val(),
      almacen: $('#almacen').val()
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
        var oTable = $('#agencias_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_agencias").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR AGENCIA ---------------------//
$('body').on('click', '#editAgencia', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "agencias/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      $('#edit_agencias').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_agencia_edit').val(data.id);
      $('#agencia_edit').val(data.nombre);
      $('#almacen_edit').val(data.almacen);
      //console.log(data.nombre+'-----');
    }
  });
});
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditAgencia').click(function(e) {
  e.preventDefault();
  var id = $('#id_agencia_edit').val();
  $.ajax({
    method:'PUT',
    url: "agencias/"+id+"",
    data: {
      id_agencia: $('#id_agencia_edit').val(),
      agencia: $('#agencia_edit').val(),
      almacen: $('#almacen_edit').val()
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#agencias_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_agencias").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteAgencia(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a esta agencia?',
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
        url: "agencias/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#agencias_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Agencia no eliminado", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
