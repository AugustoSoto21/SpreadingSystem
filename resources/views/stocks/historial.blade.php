@extends('layouts.app')
@section('title') Historial de Stocks @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i>  Historial de Stocks </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active"> Historial de Stocks </li>
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
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Stocks</h3>
            <div class="card-tools">
              @if(search_permits('Stocks','Imprimir PDF')=="Si" || search_permits('Stocks','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Stocks','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('productos.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Stocks','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('productos.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Stocks','Registrar')=="Si")
              

              <a href="{!! route('stocks.create') !!}" class="btn btn-info btn-sm text-white" data-tooltip="tooltip" data-placement="top" title="Crear Productos">
                <i class="fa fa-save"> &nbsp;Actualizar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Stocks','Ver mismo usuario')=="Si" || search_permits('Stocks','Ver todos los usuarios')=="Si" || search_permits('Stocks','Editar mismo usuario')=="Si" || search_permits('Stocks','Editar todos los usuarios')=="Si" || search_permits('Stocks','Eliminar mismo usuario')=="Si" || search_permits('Stocks','Eliminar todos los usuarios')=="Si")

          <div class="card-body">
            <table id="historial_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Agencia</th>
                  <th>Locker</th>
                  <th>Historial</th>
                  <th>Cantidad</th>
                  <th>Acciones</th>
                </tr>
                <tr>
                  <th>
                    <select name="id_agencia_new" name="id_agencia_new" class="form-control">
                      @foreach($agencias as $a)
                        <option value="{{$a->id}}">{{$a->nombre}}</option>
                      @endforeach    
                    </select>
                  </th>
                  <th>
                    <select name="locker_new" id="locker_new" class="form-control">
                      <option value="SIN PROBAR">SIN PROBAR</option>
                      <option value="STOCK">STOCK</option>
                      <option value="FALLA">FALLA</option>
                      <option value="CAMBIO">CAMBIO</option>
                    </select>
                  </th>
                  <th>
                    <select name="id_producto_new" id="id_producto_new" class="form-control">
                      @foreach($productos as $p)
                        <option value="{{$a->id}}">{{$a->detalles}} {{$a->marca}} {{$a->modelo}} {{$a->color}}</option>
                      @endforeach
                    </select>
                  </th>
                  <th><input type="number" name="cantidad_new" id="cantidad_new" class="form-control" value="0"></th>
                  <th>Guardar</th>
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
  $('#historial_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('stocks/historial') }}"
   },
    columns: [
      { data: 'id_agencia', name: 'id_agencia' },
      { data: 'locker', name: 'locker' },
      { data: 'id_producto', name: 'id_producto' },
      { data: 'cantidad', name: 'cantidad' },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});


</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
