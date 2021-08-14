@extends('layouts.app')
@section('title') Medios MP @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-credit-card"></i> Medios MP</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Medios MP</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('medios.partials.create')
    @include('medios.partials.edit')
    @include('medios.partials.show')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-credit-card"></i> Medios MP registrados</h3>
            <div class="card-tools">
              @if(search_permits('Medios MP','Imprimir PDF')=="Si" || search_permits('Medios MP','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Medios MP','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('medios.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Medios MP','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('medios.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Medios MP','Registrar')=="Si")
              
              <a class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#create_medios" data-tooltip="tooltip" data-placement="top" title="Crear Medios MP" id="createNewMedio">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Medios MP','Ver mismo usuario')=="Si" || search_permits('Medios MP','Ver todos los usuarios')=="Si" || search_permits('Medios MP','Editar mismo usuario')=="Si" || search_permits('Medios MP','Editar todos los usuarios')=="Si" || search_permits('Medios MP','Eliminar mismo usuario')=="Si" || search_permits('Medios MP','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="medios_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Medio</th>
                  <th>Porcentaje</th>
                  <th>Iva</th>
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
  $('#medios_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('medios') }}"
   },
    columns: [
      { data: 'medio', name: 'medio' },
      { data: 'porcentaje', name: 'porcentaje' },
      { data: 'iva', name: 'iva' },
      { data: 'status', name: 'status' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR MEDIOS (LEVANTAR EL MODAL) ---------------------//
$('#createNewMedio').click(function () {
  $('#medioForm').trigger("reset");
  $('#create_medios').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR MEDIOS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateMedio').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var interes=[];
  
  $.ajax({
    
    url: "{{ route('medios.store') }}",
    method: 'post',
    data: $('#medioForm').serialize(),
    success: function(result) {
      
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        var oTable = $('#medios_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_medios").modal('hide');
        }
      }
    }
  });
});

//--CODIGO PARA EDITAR MEDIO ---------------------//
$('body').on('click', '#editMedio', function () {
  var id = $(this).data('id');
  
  $.ajax({
    method:"GET",
    url: "medios/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      
      $('#edit_medios').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_medio_edit').val(data[0].id);
      $('#medio_edit').val(data[0].medio);
      $('#porcentaje_edit').val(data[0].porcentaje);
      mostrar_cuotas(data[0].id);
    }
  });
});
//--CODIGO PARA UPDATE MEDIO ---------------------//
$('#SubmitEditMedio').click(function(e) {
  e.preventDefault();
  var id = $('#id_medio_edit').val();
  $.ajax({
    method:'PUT',
    url: "medios/"+id+"",
    data: $('#medioFormEdit').serialize(),
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#medios_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_medios").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA VER MEDIO Y  SUS CUOTAS---------------------//
$('body').on('click', '#showMedio', function () {
  var id = $(this).data('id');
  
  $.ajax({
    method:"GET",
    url: "medios/"+id+"/edit",
    dataType: 'json',
    success: function(data){
      
      $('#show_medios').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#medio_show').val(data[0].medio);
      $('#porcentaje_show').val(data[0].porcentaje);
      mostrar_cuotas2(data[0].id);
    }
  });
});
//--CODIGO PARA ELIMINAR MEDIO ---------------------//
function deleteMedio(id){
  var id = id;
  Swal.fire({
    title: '¿Estás seguro que desea eliminar a este medio?',
    text: "¡Esta opción no podrá deshacerse en el futuro, y al hacerlo el medio anteriormente registraso quedará activo para el sistema!",
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
        url: "medios/"+id+"",
        data: { id: id },
        dataType: 'json',
        success: function(response){
          Swal.fire ( response.titulo ,  response.message ,  response.icono );
          var oTable = $('#medios_table').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire({title: "Error del servidor", text:  "Medio no eliminado", icon:  "error"});
        }
      });
    }
  })
}
function mostrar_cuotas(id_medio) {
  
  $.get('/medios/'+id_medio+'/buscar_cuotas',function (data) {})
    .done(function(data) {
      for (var i = 0; i < data.length; i++) {
        $("#interes_edit"+data[i].cant_cuota).val(data[i].interes);
      }
    });
}
function mostrar_cuotas2(id_medio) {
  
  $.get('/medios/'+id_medio+'/buscar_cuotas',function (data) {})
    .done(function(data) {
      for (var i = 0; i < data.length; i++) {
        $("#interes_show"+data[i].cant_cuota).val(data[i].interes);
      }
    });
}

</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
