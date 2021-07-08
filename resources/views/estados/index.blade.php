@extends('layouts.app')
@section('title') Estados @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i> Estados</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Estados</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('estados.partials.create')
    @include('estados.partials.edit')
    @include('estados.partials.delete')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Estados registrados</h3>
            <div class="card-tools">
              @if(search_permits('Estados','Imprimir PDF')=="Si" || search_permits('Estados','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Estados','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('estados.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Estados','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('estados.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Estados','Registrar')=="Si")
              {{-- <a href="{!! route('estados.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar estado"><i class="fas fa-edit"></i> Registrar estados</a> --}}

              <a class="btn btn-info btn-xs text-white" data-toggle="modal" data-target="#create_estados" onclick="create_estados()" data-tooltip="tooltip" data-placement="top" title="Crear Estados">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Estados','Ver mismo usuario')=="Si" || search_permits('Estados','Ver todos los usuarios')=="Si" || search_permits('Estados','Editar mismo usuario')=="Si" || search_permits('Estados','Editar todos los usuarios')=="Si" || search_permits('Estados','Eliminar mismo usuario')=="Si" || search_permits('Estados','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="estados" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Estado</th>
                  <th>Color</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($estados as $k)
                  
                  <tr >
                    <td>{!!$k->estado!!}</td>
                    <td bgcolor="{!!$k->color!!}">{!!$k->color!!}</td>
                    
                    <td>
                      <!--ACCIÓN DE VER PRODUCTOS -->
                      {{-- @if(search_permits('Estados','Ver todos los usuarios')=="Si")
                        <a href="{!! route('estados.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver estado"><i class="fa fa-search"></i></a>
                      @elseif(search_permits('Estados','Ver mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('estados.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver estado"><i class="fa fa-search"></i></a>
                        @endif
                      @endif
 --}}
                      <!--ACCIÓN DE EDITAR PRODUCTOS -->
                      @if(search_permits('Estados','Editar todos los usuarios')=="Si")
                        <a href="{!! route('estados.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_estados" onclick="edit_estados('{!! $k->id !!}','{!! $k->estado !!}','{!! $k->color !!}')" data-tooltip="tooltip" data-placement="top" title="Editar estado"><i class="fa fa-pencil-alt"></i></a>
                      @elseif(search_permits('Estados','Editar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('estados.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_estados" onclick="edit_estados('{!! $k->id !!}','{!! $k->estado !!}','{!! $k->color !!}')" data-tooltip="tooltip"  data-placement="top" title="Editar estado"><i class="fa fa-pencil-alt"></i></a>
                        @endif
                      @endif

                      <!--ACCIÓN DE ELIMINAR PRODUCTO -->
                      @if(search_permits('Estados','Eliminar todos los usuarios')=="Si")
                        <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_estados" onclick="delete_estados('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar estado">
                          <i class="fa fa-trash"></i>
                        </a>
                      @elseif(search_permits('Estados','Eliminar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_estados" onclick="delete_estados('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar estado">
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
    $("#estados").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  function delete_estados(id) {
    $('#delete_id').val(id);
  }
  
</script>
<script type="text/javascript">
  function edit_estados(id,estado, color) {
    $('#id_estado').val(id);
    $('#estado_edit').val(estado);
    $('#color_edit').val(color);
  }
</script>
@endsection
