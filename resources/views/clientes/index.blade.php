@extends('layouts.app')
@section('title') Clientes @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-users"></i> Clientes</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Clientes</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('clientes.partials.create')
    @include('clientes.partials.edit')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-users"></i> Clientes registrados</h3>
            <div class="card-tools">
              @if(search_permits('Clientes','Imprimir PDF')=="Si" || search_permits('Clientes','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Clientes','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('clientes.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Clientes','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('clientes.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Clientes','Registrar')=="Si")
              {{-- <a href="{!! route('clientes.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar cliente"><i class="fas fa-edit"></i> Registrar clientes</a> --}}

              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_clientes" data-tooltip="tooltip" data-placement="top" title="Crear Clientes">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Clientes','Ver mismo usuario')=="Si" || search_permits('Clientes','Ver todos los usuarios')=="Si" || search_permits('Clientes','Editar mismo usuario')=="Si" || search_permits('Clientes','Editar todos los usuarios')=="Si" || search_permits('Clientes','Eliminar mismo usuario')=="Si" || search_permits('Clientes','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="clientes_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Celular</th>
                  <th>Dirección</th>
                  <th>Localidad</th>
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
  $('#clientes_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('clientes') }}"
   },
    columns: [
      { data: 'nombres', name: 'nombres' },
      { data: 'apellidos', name: 'apellidos' },
      { data: 'celular', name: 'celular' },
      { data: 'direccion', name: 'direccion' },
      { data: 'localidad', name: 'localidad' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});

//--CODIGO PARA CREAR PBX (LEVANTAR EL MODAL) ---------------------//
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
        var oTable = $('#clientes_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_clientes").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR AGENCIA ---------------------//
$('body').on('click', '#editCliente', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "clientes/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      $('#edit_clientes').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_cliente_edit').val(data.id);
      $('#nombres_edit').val(data.nombres);
      $('#apellidos_edit').val(data.apellidos);
      $('#celular_edit').val(data.celular);
      $('#direccion_edit').val(data.direccion);
      $('#localidad_edit').val(data.localidad);
    }
  });
});
//--CODIGO PARA UPDATE ESTADO ---------------------//
$('#SubmitEditCliente').click(function(e) {
  e.preventDefault();
  var id = $('#id_cliente_edit').val();
  $.ajax({
    method:'PUT',
    url: "clientes/"+id+"",
    data: {
      id_cliente: $('#id_cliente_edit').val(),
      nombres: $('#nombres_edit').val(),
      apellidos: $('#apellidos_edit').val(),
      celular: $('#celular_edit').val(),
      direccion: $('#direccion_edit').val(),
      localidad: $('#localidad_edit').val()
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#clientes_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_clientes").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA ELIMINAR ESTADO ---------------------//
function deleteCliente(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a esta cliente?',
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
        url: "clientes/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#clientes_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Cliente no eliminado", icon:  "error"});
        }
      });
    }
  })
}
 
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
