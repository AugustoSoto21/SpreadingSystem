@extends('layouts.app')
@section('title') Agencias @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i> Agencias</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Agencias</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('agencias.partials.create')
    @include('agencias.partials.edit')
    @include('agencias.partials.delete')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Agencias registradas</h3>
            <div class="card-tools">
              @if(search_permits('Agencias','Imprimir PDF')=="Si" || search_permits('Agencias','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Agencias','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('agencias.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Agencias','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('agencias.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Agencias','Registrar')=="Si")
              {{-- <a href="{!! route('agencias.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar agencia"><i class="fas fa-edit"></i> Registrar agencias</a> --}}

              <a class="btn btn-info btn-xs text-white" data-toggle="modal" data-target="#create_agencias" onclick="create_agencias()" data-tooltip="tooltip" data-placement="top" title="Crear Agencias">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          {{-- @if(search_permits('Agencias','Ver mismo usuario')=="Si" || search_permits('Agencias','Ver todos los usuarios')=="Si" || search_permits('Agencias','Editar mismo usuario')=="Si" || search_permits('Agencias','Editar todos los usuarios')=="Si" || search_permits('Agencias','Eliminar mismo usuario')=="Si" || search_permits('Agencias','Eliminar todos los usuarios')=="Si") --}}
          <div class="card-body">
            <table id="agencias" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Agencia</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($agencias as $k)
                  
                  <tr >
                    <td>{!!$k->nombre!!}</td>
                    <td>
                      <!--ACCIÓN DE VER PRODUCTOS -->
                      {{-- @if(search_permits('Agencias','Ver todos los usuarios')=="Si")
                        <a href="{!! route('agencias.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver agencia"><i class="fa fa-search"></i></a>
                      @elseif(search_permits('Agencias','Ver mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('agencias.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver agencia"><i class="fa fa-search"></i></a>
                        @endif
                      @endif
 --}}
                      <!--ACCIÓN DE EDITAR PRODUCTOS -->
                      @if(search_permits('Agencias','Editar todos los usuarios')=="Si")
                        <a href="{!! route('agencias.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_agencias" onclick="edit_agencias('{!! $k->id !!}','{!! $k->nombre !!}')" data-tooltip="tooltip" data-placement="top" title="Editar agencia"><i class="fa fa-pencil-alt"></i></a>
                      @elseif(search_permits('Agencias','Editar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('agencias.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_agencias" onclick="edit_agencias('{!! $k->id !!}','{!! $k->nombre !!}')" data-tooltip="tooltip"  data-placement="top" title="Editar agencia"><i class="fa fa-pencil-alt"></i></a>
                        @endif
                      @endif

                      <!--ACCIÓN DE ELIMINAR PRODUCTO -->
                      @if(search_permits('Agencias','Eliminar todos los usuarios')=="Si")
                        <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_agencias" onclick="delete_agencias('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar agencia">
                          <i class="fa fa-trash"></i>
                        </a>
                      @elseif(search_permits('Agencias','Eliminar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_agencias" onclick="delete_agencias('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar agencia">
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
    $("#agencias").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  function delete_agencias(id) {
    $('#delete_id').val(id);
  }
  
</script>
<script type="text/javascript">
  function edit_agencias(id,agencia) {
    $('#id_agencia').val(id);
    $('#agencia_edit').val(agencia);
  }
</script>
@endsection
