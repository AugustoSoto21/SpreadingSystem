@extends('layouts.app')
@section('title') Stocks de Productos @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fas fa-tasks"></i> Stocks de Productos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Stocks de Productos</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true"><i class="nav-icon fas fa-tasks"></i> Stocks</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false"><i class="nav-icon fas fa-tasks"></i> Almacen</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <div class="card card-primary card-outline card-tabs">
                      <div class="card-header">
                        <h3 class="card-title"><i class="nav-icon fas fa-tasks"></i> Stocks</h3>
                        <!-- <div class="card-tools">
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
                        </div> -->
                      </div>
                      @if(search_permits('Stocks','Ver mismo usuario')=="Si" || search_permits('Stocks','Ver todos los usuarios')=="Si" || search_permits('Stocks','Editar mismo usuario')=="Si" || search_permits('Stocks','Editar todos los usuarios')=="Si" || search_permits('Stocks','Eliminar mismo usuario')=="Si" || search_permits('Stocks','Eliminar todos los usuarios')=="Si")

                      <div class="card-body">
                        <table id="productos_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                          <thead>
                            <tr>
                              <th>Código</th>
                              <th>Categoría</th>
                              <th>Detalles</th>
                              <th>Status</th>
                              <th>Stock</th>
                              <th>Disponibles</th>
                              <th>Mínimo</th>
                              <th>Probar</th>
                              <th>Fallas</th>
                              <th>Devueltos</th>
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
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                    <div class="card card-primary card-outline card-tabs">
                      <div class="card-header">
                        <h3 class="card-title"><i class="nav-icon fas fa-tasks"></i> Almacen</h3>
                        <!-- <div class="card-tools">
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
                        </div> -->
                      </div>
                      @if(search_permits('Stocks','Ver mismo usuario')=="Si" || search_permits('Stocks','Ver todos los usuarios')=="Si" || search_permits('Stocks','Editar mismo usuario')=="Si" || search_permits('Stocks','Editar todos los usuarios')=="Si" || search_permits('Stocks','Eliminar mismo usuario')=="Si" || search_permits('Stocks','Eliminar todos los usuarios')=="Si")

                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="agencias">Agencias: <b style="color: red;">*</b></label>
                              <select class="form-control form-control-sm" name="agencias" id="agencias">
                                @foreach($agencias as $k)
                                  <option value="{!! $k->id !!}">{!!$k->nombre!!}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <button type="button" id="filter" class="btn btn-primary btn-sm btn-block" style="margin-top: 30px;" name="filter"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <button type="button" name="refresh" id="refresh" class="btn btn-default btn-sm btn-block" style="margin-top: 30px;"><i class="fa fa-sync-alt"></i> Refrescar</button>
                          </div>
                        </div><hr>
                        <table id="almacen_table" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                          <thead>
                            <tr>
                              <th>Código</th>
                              <th>Categoría</th>
                              <th>Detalles</th>
                              <th>Status</th>
                              <th>Stock</th>
                              <th>Disponibles</th>
                              <th>Mínimo</th>
                              <th>Fallas</th>
                              <th>Reclamos</th>
                              <th>Devueltos</th>
                              <!-- <th>Acciones</th> -->
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
              </div>
              <!-- /.card -->
            </div>
          </div>
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
  table = $('#almacen_table').DataTable( {
      paging: false,
      searching: false,
  } );
   
  table.destroy();
  $('#productos_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url:"{{ url('stocks') }}"
   },
    columns: [
      { data: 'codigo', name: 'codigo' },
      { data: 'categoria', name: 'categoria' },
      { data: 'detalles', name: 'detalles' },
      { data: 'status', name: 'status' },
      { data: 'stock', name: 'stock' },
      { data: 'stock_disponible', name: 'stock_disponible' },
      { data: 'stock_min', name: 'stock_min' },
      { data: 'stock_probar', name: 'stock_probar' },
      { data: 'stock_fallas', name: 'stock_fallas' },
      { data: 'stock_devueltos', name: 'stock_devueltos' },
      
    ],
    order: [[0, 'desc']]
  });
});

$('#filter').on('click',function (event) {
  var id_agencia=$("#agencias").val();
  
  $('#almacen_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    destroy: true,
    ajax: {
      url:"stocks/"+id_agencia+"/buscar",
   },
    columns: [
      { data: 'codigo', name: 'codigo' },
      { data: 'categoria', name: 'categoria' },
      { data: 'detalles', name: 'detalles' },
      { data: 'status', name: 'status' },
      { data: 'stock', name: 'stock' },
      { data: 'stock_disponible', name: 'stock_disponible' },
      { data: 'stock_min', name: 'stock_min' },
      { data: 'stock_fallas', name: 'stock_fallas' },
      { data: 'stock_reclamos', name: 'stock_reclamos' },
      { data: 'stock_devueltos', name: 'stock_devueltos', orderable: false },
    ],
    order: [[0, 'desc']]
  });
})
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
