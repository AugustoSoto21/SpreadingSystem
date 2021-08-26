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
  </div><!-- /.container-fluid -->
</section>
@endsection
@section('scripts')
<script>
$(document).ready(function(){ 
 load_data();
 function load_data(fecha = '', id_agencia = '', id_estado = '' , todas = '' , todos = '') {
  $(document).ready( function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#pedidos_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url:"{{ url('pedidos') }}",
        data:{
          fecha:fecha,
          id_agencia:id_agencia,
          id_estado:id_estado,
          todas:todas,
          todos:todos
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
      order: [[0, 'desc']]
    });
  });
}
 $('#filter').click(function(){
  var fecha = $('#fecha').val();
  var id_agencia = $('#id_agencia').val();
  var id_estado = $('#id_estado').val();
  var todas = $('#todas').val();
  var todas = $('#todas').val();
  if(fecha != '' &&  id_agencia != '' &&  id_estado != '' && todas != '' && todos != '') {
    $('#pedidos_table').DataTable().destroy();
    load_data(fecha,id_agencia,id_estado,todas,todos);
    /*$('#text_date_from').text(date_from);
    $('#text_date_to').text(date_to);
    $("#range_date").removeAttr('style');*/
    $('#filtro_pedido').modal('hide');
  } else {
    Swal.fire({ title: 'Advertencia' ,  text: 'Todos los campos del filtro son obligatorios.' ,  icon:'warning' });
  }
 });
 
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
