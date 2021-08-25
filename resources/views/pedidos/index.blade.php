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

              <a href="{!! route('pedidos.create') !!}" class="btn btn-info btn-sm text-white" data-tooltip="tooltip" data-placement="top" title="Crear Pedidos">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
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
                {{$tabla}}
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

 /* $('#pedidos_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('pedidos') }}"
   },
    columns: [
      { data: 'codigo', name: 'codigo' },
      { data: 'id_cliente', name: 'id_cliente' },
      { data: 'id_user', name: 'id_user' },
      { data: 'total_fact', name: 'total_fact' },
      { data: 'envio_gratis', name: 'envio_gratis' },
      { data: 'monto_tarifa', name: 'monto_tarifa' },
      { data: 'id_fuente', name: 'id_fuente', orderable: false },
      { data: 'id_estado', name: 'id_estado' },
      { data: 'observacion', name: 'observacion' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});*/
/*

</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
