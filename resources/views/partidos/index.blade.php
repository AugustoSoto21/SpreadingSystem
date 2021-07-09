@extends('layouts.app')
@section('title') Partidos @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i> Partidos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Partidos</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('partidos.partials.create')
    @include('partidos.partials.edit')
    @include('partidos.partials.delete')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Partidos registrados</h3>
            <div class="card-tools">
              @if(search_permits('Partidos','Imprimir PDF')=="Si" || search_permits('Partidos','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Partidos','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('partidos.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Partidos','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('partidos.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Partidos','Registrar')=="Si")
              {{-- <a href="{!! route('partidos.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar partido"><i class="fas fa-edit"></i> Registrar partidos</a> --}}

              <a class="btn btn-info btn-xs text-white" data-toggle="modal" data-target="#create_partidos" onclick="create_partidos()" data-tooltip="tooltip" data-placement="top" title="Crear Partidos">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          {{-- @if(search_permits('Partidos','Ver mismo usuario')=="Si" || search_permits('Partidos','Ver todos los usuarios')=="Si" || search_permits('Partidos','Editar mismo usuario')=="Si" || search_permits('Partidos','Editar todos los usuarios')=="Si" || search_permits('Partidos','Eliminar mismo usuario')=="Si" || search_permits('Partidos','Eliminar todos los usuarios')=="Si") --}}
          <div class="card-body">
            <table id="partidos" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Partido</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($partidos as $k)
                  
                  <tr >
                    <td>{!!$k->partido!!}</td>
                    <td>
                      <!--ACCIÓN DE VER PRODUCTOS -->
                      {{-- @if(search_permits('Partidos','Ver todos los usuarios')=="Si")
                        <a href="{!! route('partidos.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver partido"><i class="fa fa-search"></i></a>
                      @elseif(search_permits('Partidos','Ver mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('partidos.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver partido"><i class="fa fa-search"></i></a>
                        @endif
                      @endif
 --}}
                      <!--ACCIÓN DE EDITAR PRODUCTOS -->
                      @if(search_permits('Partidos','Editar todos los usuarios')=="Si")
                        <a href="{!! route('partidos.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_partidos" onclick="edit_partidos('{!! $k->id !!}','{!! $k->partido !!}')" data-tooltip="tooltip" data-placement="top" title="Editar partido"><i class="fa fa-pencil-alt"></i></a>
                      @elseif(search_permits('Partidos','Editar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('partidos.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_partidos" onclick="edit_partidos('{!! $k->id !!}','{!! $k->partido !!}')" data-tooltip="tooltip"  data-placement="top" title="Editar partido"><i class="fa fa-pencil-alt"></i></a>
                        @endif
                      @endif

                      <!--ACCIÓN DE ELIMINAR PRODUCTO -->
                      @if(search_permits('Partidos','Eliminar todos los usuarios')=="Si")
                        <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_partidos" onclick="delete_partidos('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar partido">
                          <i class="fa fa-trash"></i>
                        </a>
                      @elseif(search_permits('Partidos','Eliminar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_partidos" onclick="delete_partidos('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar partido">
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
          {{-- @else
          <div class="row">
            <div class="col-12">                          
              <div class="alert alert-danger alert-dismissible text-center">
                <h5><i class="icon fas fa-ban"></i> ¡Alerta!</h5>
                ACCESO RESTRINGIDO, NO POSEE PERMISO.
              </div>
            </div>
          </div>
          @endif --}}
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@endsection
@section('scripts')
<script>
  $(function () {
    $("#partidos").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  function delete_partidos(id) {
    $('#delete_id').val(id);
  }
  
</script>
<script type="text/javascript">
  function edit_partidos(id,partido) {
    $('#id_partido').val(id);
    $('#partido_edit').val(partido);
  }
</script>
@endsection
