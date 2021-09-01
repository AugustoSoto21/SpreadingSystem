@extends('layouts.app')
@section('title') Pedidos @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i> Pedidos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Pedidos</li>
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
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Pedidos registrados</h3>
            <div class="card-tools">
              @if(search_permits('Pedidos','Imprimir PDF')=="Si" || search_permits('Pedidos','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Pedidos','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('pedidos.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Pedidos','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('pedidos.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Pedidos','Registrar')=="Si")
              {{-- <a href="{!! route('pedidos.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar pedido"><i class="fas fa-edit"></i> Registrar pedidos</a> --}}

              <a class="btn bg-gradient-primary btn-sm pull-right text-white" data-toggle="modal" data-target="#filtro_pedido" data-tooltip="tooltip" data-placement="top" title="Filtro de búsqueda"><i class="fas fa-search"></i> Filtro de búsqueda</a>
              <button type="button" name="refresh" id="refresh" class="btn btn-default btn-sm"><i class="fa fa-sync-alt"></i> Refrescar</button>
              @endif
            </div>
          </div>
          @if(search_permits('Pedidos','Ver mismo usuario')=="Si" || search_permits('Pedidos','Ver todos los usuarios')=="Si" || search_permits('Pedidos','Editar mismo usuario')=="Si" || search_permits('Pedidos','Editar todos los usuarios')=="Si" || search_permits('Pedidos','Eliminar mismo usuario')=="Si" || search_permits('Pedidos','Eliminar todos los usuarios')=="Si")

          <div class="card-body">
            <table id="pedidos_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Cliente</th>
                  <th>Registrado por:</th>
                  <th>Total</th>
                  <th>Envío Gratis</th>
                  <th>Tarifa</th>
                  <th>Fuente</th>
                  <th>Estado</th>
                  <th>Observación</th>
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
    @include('pedidos.partials.filtros')
    @include('pedidos.partials.remito')
  </div><!-- /.container-fluid -->
</section>
@endsection
@section('scripts')
<script>
$(document).ready(function(){ 
 load_data();
  function load_data(id_agencia = '', todos_estados = '', id_estado_filtro = '' , date_from = '' , date_to = '') {
    $(document).ready( function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#pedidos_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: {
          url:"{{ url('pedidos') }}",
          data:{
            id_agencia:id_agencia,
            todos_estados:todos_estados,
            id_estado_filtro:id_estado_filtro,
            date_from:date_from,
            date_to:date_to
          }
       },
        columns: [
          { data: 'codigo', name: 'codigo' },
          { data: 'id_cliente', name: 'id_cliente' },
          { data: 'id_user', name: 'id_user' },
          { data: 'total_fact', name: 'total_fact' },
          { data: 'envio_gratis', name: 'envio_gratis' },
          { data: 'monto_tarifa', name: 'monto_tarifa' },
          { data: 'id_fuente', name: 'id_fuente' },
          { data: 'id_estado', name: 'id_estado' },
          { data: 'observacion', name: 'observacion' },
          {data: 'action', name: 'action', orderable: false},
        ],
        createdRow: function(row,data,index){
          $('td',row).css('background',data.color);
        },
        order: [[0, 'desc']]
      });
    });
  }
  $('#filter').click(function(){
    var id_agencia = $('#id_agencia').val();
    var todos_estados = $('#todos_estados').val();
    var id_estado_filtro = $('#id_estado_filtro').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    console.log(todos_estados);
    if(id_agencia != '' && date_from != '' && date_to != '') {
      $('#pedidos_table').DataTable().destroy();
      load_data(id_agencia,todos_estados,id_estado_filtro,date_from,date_to);
      /*$('#text_date_from').text(date_from);
      $('#text_date_to').text(date_to);
      $("#range_date").removeAttr('style');*/
      $('#filtro_pedido').modal('hide');
    } else {
      Swal.fire({ title: 'Advertencia' ,  text: 'Todos los campos del filtro son obligatorios.' ,  icon:'warning' });
    }
  });
});
function changeEstados(){
  if ($('#todos_estados').prop('checked')) {
    $('#id_estado_filtro').prop('disabled',true).prop('required', false);
    $('#todos_estados').val('activo');
  }else{
    $('#id_estado_filtro').prop('disabled',false).prop('required', true);
    $('#todos_estados').val('inactivo');
  }
}
function remitoPedido(id_pedido) {
  
  $.ajax({
    method:"GET",
    url: "/pedidos/"+id_pedido+"show",
    dataType: 'json',
    success: function(data){
      $('#remito_pedido').modal({backdrop: 'static', keyboard: true, show: true});
      //console.log(data.length);
      $('.alert-danger').hide();
      $('#fecha').text(data[0].created_at);
      $('#cliente').text(data[0].nombres+' '+data[0].apellidos);
      $('#direccion').text(data[0].direccion);
      $('#celular').text(data[0].celular);
      $('#status_edit').text(data.status);

      for (var i = 0; i < data.length; i++) {
        $("#invoice_remito").append("<tr><td>"+data[i].cantidad+"</td><td>"+data[i].detalles+" "+data[i].modelo+" "+data[i].marca+" "+data[i].color_p+"</td><td>"+data[i].monto_und+"</td><td>"+data[i].total_pp+"</td></tr>");
      }
      $('#descuento').text(data[0].descuento_total);
      $('#iva').text(data[0].iva_total);
      $('#recargo').text(data[0].recargo_ct);
      $('#total').text(data[0].total_fact);
      buscar_horarios(data[0].codigo);
    }
  });  

}
function buscar_horarios(codigo) {

    $.get('/pedidos/'+codigo+'/buscar_horarios',function (data) {
      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
            $("#mostrar_horarios").append("<tr><td>"+data[i].horario+"</td><td>"+data[i].hora_inicio+"</td><td>"+data[i].hora_fin+"</td><td>"+data[i].direccion+"</td></tr>");   
        }
      }
    });
}
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
