@extends('layouts.app')
@section('title') Clientes @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i> Clientes</h1>
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
    @include('clientes.partials.delete')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Clientes registrados</h3>
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

              <a class="btn btn-info btn-xs text-white" data-toggle="modal" data-target="#create_clientes" onclick="create_clientes()" data-tooltip="tooltip" data-placement="top" title="Crear Clientes">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Clientes','Ver mismo usuario')=="Si" || search_permits('Clientes','Ver todos los usuarios')=="Si" || search_permits('Clientes','Editar mismo usuario')=="Si" || search_permits('Clientes','Editar todos los usuarios')=="Si" || search_permits('Clientes','Eliminar mismo usuario')=="Si" || search_permits('Clientes','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="clientes" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
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
                @foreach($clientes as $k)
                  
                  <tr >
                    <td>{!!$k->nombres!!}</td>
                    <td>{!!$k->apellidos!!}</td>
                    <td>{!!$k->celular!!}</td>
                    <td>{!!$k->direccion!!}</td>
                    <td>{!!$k->localidad!!}</td>
                    <td>
                      <!--ACCIÓN DE VER PRODUCTOS -->
                      {{-- @if(search_permits('Clientes','Ver todos los usuarios')=="Si")
                        <a href="{!! route('clientes.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver cliente"><i class="fa fa-search"></i></a>
                      @elseif(search_permits('Clientes','Ver mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('clientes.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver cliente"><i class="fa fa-search"></i></a>
                        @endif
                      @endif
 --}}
                      <!--ACCIÓN DE EDITAR PRODUCTOS -->
                      @if(search_permits('Clientes','Editar todos los usuarios')=="Si")
                        <a href="{!! route('clientes.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_clientes" onclick="edit_clientes('{!! $k->id !!}','{!! $k->nombres !!}','{!! $k->apellidos !!}','{!! $k->celular !!}','{!! $k->direccion !!}','{!! $k->localidad !!}')" data-tooltip="tooltip" data-placement="top" title="Editar cliente"><i class="fa fa-pencil-alt"></i></a>
                      @elseif(search_permits('Clientes','Editar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('clientes.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_clientes" onclick="edit_clientes('{!! $k->id !!}','{!! $k->nombres !!}','{!! $k->apellidos !!}','{!! $k->celular !!}','{!! $k->direccion !!}','{!! $k->localidad !!}')" data-tooltip="tooltip"  data-placement="top" title="Editar cliente"><i class="fa fa-pencil-alt"></i></a>
                        @endif
                      @endif

                      <!--ACCIÓN DE ELIMINAR PRODUCTO -->
                      @if(search_permits('Clientes','Eliminar todos los usuarios')=="Si")
                        <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_clientes" onclick="delete_clientes('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar cliente">
                          <i class="fa fa-trash"></i>
                        </a>
                      @elseif(search_permits('Clientes','Eliminar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_clientes" onclick="delete_clientes('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar cliente">
                          <i class="fa fa-trash"></i>
                        </a>
                        @endif
                      @endif
                      
                    </td>
                  </tr>
                  
                @endforeach
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
  $(function () {
    $("#clientes").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  function delete_clientes(id) {
    $('#delete_id').val(id);
  }
  
</script>
<script type="text/javascript">
  function edit_clientes(id,nombres,apellidos,celular,direccion,localidad) {
    $('#id_cliente_x').val(id);
    $('#nombres_edit').val(nombres);
    $('#apellidos_edit').val(apellidos);
    $('#celular_edit').val(celular);
    $('#direccion_edit').val(direccion);
    $('#localidad_edit').val(localidad);
  }
</script>
@endsection
