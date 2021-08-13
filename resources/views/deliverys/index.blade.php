@extends('layouts.app')
@section('title') Deliverys @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-motorcycle"></i> Deliverys</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Deliverys</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('deliverys.partials.create')
    @include('deliverys.partials.edit')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-motorcycle"></i> Deliverys registrados</h3>
            <div class="card-tools">
              @if(search_permits('Deliverys','Imprimir PDF')=="Si" || search_permits('Deliverys','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Deliverys','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('deliverys.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Deliverys','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('deliverys.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Deliverys','Registrar')=="Si")
              
              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_deliverys" data-tooltip="tooltip" data-placement="top" title="Crear Deliverys" id="createNewDelivery">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Deliverys','Ver mismo usuario')=="Si" || search_permits('Deliverys','Ver todos los usuarios')=="Si" || search_permits('Deliverys','Editar mismo usuario')=="Si" || search_permits('Deliverys','Editar todos los usuarios')=="Si" || search_permits('Deliverys','Eliminar mismo usuario')=="Si" || search_permits('Deliverys','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="deliverys_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Delivery</th>
                  <th>Agencia</th>
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
  $('#deliverys_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('deliverys') }}"
   },
    columns: [
      { data: 'delivery', name: 'delivery' },
      { data: 'nombre', name: 'nombre' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR DELIVERYS (LEVANTAR EL MODAL) ---------------------//
$('#createNewDelivery').click(function () {
  $('#deliveryForm').trigger("reset");
  $('#create_deliverys').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR DELIVERYS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateDelivery').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('deliverys.store') }}",
    method: 'post',
    data: {
      delivery: $('#delivery').val(),
      id_agencia: $('#id_agencia').val(),
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
        var oTable = $('#deliverys_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_deliverys").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR DELIVERY ---------------------//
$('body').on('click', '#editDelivery', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "deliverys/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      
      $('#edit_deliverys').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_delivery_edit').val(data[0].id);
      $('#delivery_edit').val(data[0].delivery);
      $("#id_agencia_edit option[value='"+ data[0].id_agencia +"']").attr("selected",true);
      //$('#id_agencia_edit').val(data.id_agencia);
    }
  });
});
//--CODIGO PARA UPDATE DELIVERY ---------------------//
$('#SubmitEditDelivery').click(function(e) {
  e.preventDefault();
  var id = $('#id_delivery_edit').val();
  $.ajax({
    method:'PUT',
    url: "deliverys/"+id+"",
    data: {
      id_delivery: $('#id_delivery_edit').val(),
      delivery: $('#delivery_edit').val(),
      id_agencia: $('#id_agencia_edit').val()
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#deliverys_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_deliverys").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA ELIMINAR DELIVERY ---------------------//
function deleteDelivery(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a este delivery?',
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
        url: "deliverys/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#deliverys_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Delivery no eliminado", icon:  "error"});
        }
      });
    }
  })
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
