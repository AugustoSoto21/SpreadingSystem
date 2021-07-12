@extends('layouts.app')
@section('title') Deliverys @endsection
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-basket"></i> Deliverys</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Deliverys</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('deliverys.partials.create')
    @include('deliverys.partials.edit')
    @include('deliverys.partials.delete')
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-tabs">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-shopping-basket"></i> Deliverys registrados</h3>
            <div class="card-tools">
              @if(search_permits('Deliverys','Imprimir PDF')=="Si" || search_permits('Deliverys','Imprimir Excel')=="Si")
              <div class="btn-group">
                <a class="btn btn-danger dropdown-toggle btn-sm dropdown-icon text-white" data-toggle="dropdown" data-tooltip="tooltip" data-placement="top" title="Generar reportes">Imprimir </a>
                <div class="dropdown-menu dropdown-menu-right">
                  @if(search_permits('Deliverys','Imprimir PDF')=="Si")
                  {{-- <a class="dropdown-item" href="{!!route('deliverys.pdf')!!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en PDF"><i class="fa fa-file-pdf"></i> Exportar a PDF</a> --}}
                  @endif
                  {{-- @if(search_permits('Deliverys','Imprimir Excel')=="Si")
                  <a class="dropdown-item" href="{!! route('deliverys.excel') !!}" target="_blank" data-tooltip="tooltip" data-placement="top" title="Reportes en Excel"><i class="fa fa-file-excel"></i> Exportar a Excel</a>
                  @endif --}}
                </div>
              </div>
              @endif
              @if(search_permits('Deliverys','Registrar')=="Si")
              {{-- <a href="{!! route('deliverys.create') !!}" class="btn bg-gradient-primary btn-sm pull-right" data-tooltip="tooltip" data-placement="top" title="Registrar delivery"><i class="fas fa-edit"></i> Registrar deliverys</a> --}}

              <a class="btn btn-info btn-xs text-white" data-toggle="modal" data-target="#create_deliverys" onclick="create_deliverys()" data-tooltip="tooltip" data-placement="top" title="Crear Deliverys">
                <i class="fa fa-save"> &nbsp;Registrar</i>
              </a>
              @endif
            </div>
          </div>
          @if(search_permits('Deliverys','Ver mismo usuario')=="Si" || search_permits('Deliverys','Ver todos los usuarios')=="Si" || search_permits('Deliverys','Editar mismo usuario')=="Si" || search_permits('Deliverys','Editar todos los usuarios')=="Si" || search_permits('Deliverys','Eliminar mismo usuario')=="Si" || search_permits('Deliverys','Eliminar todos los usuarios')=="Si")
          <div class="card-body">
            <table id="deliverys" class="table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Delivery</th>
                  <th>Agencia</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($deliverys as $k)
                  
                  <tr >
                    <td>{!!$k->delivery!!}</td>
                    <td>{!!$k->agencias->nombre!!}</td>
                    
                    <td>
                      <!--ACCIÓN DE VER PRODUCTOS -->
                      {{-- @if(search_permits('Deliverys','Ver todos los usuarios')=="Si")
                        <a href="{!! route('deliverys.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver delivery"><i class="fa fa-search"></i></a>
                      @elseif(search_permits('Deliverys','Ver mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('deliverys.show', $k->id) !!}" class="btn btn-info btn-xs" data-tooltip="tooltip" data-placement="top" title="Ver delivery"><i class="fa fa-search"></i></a>
                        @endif
                      @endif
 --}}
                      <!--ACCIÓN DE EDITAR PRODUCTOS -->
                      @if(search_permits('Deliverys','Editar todos los usuarios')=="Si")
                        <a href="{!! route('deliverys.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_deliverys" onclick="edit_deliverys('{!! $k->id !!}','{!! $k->delivery !!}','{!! $k->id_agencia !!}')" data-tooltip="tooltip" data-placement="top" title="Editar delivery"><i class="fa fa-pencil-alt"></i></a>
                      @elseif(search_permits('Deliverys','Editar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a href="{!! route('deliverys.edit', $k->id) !!}" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_deliverys" onclick="edit_deliverys('{!! $k->id !!}','{!! $k->delivery !!}','{!! $k->id_agencia !!}')" data-tooltip="tooltip"  data-placement="top" title="Editar delivery"><i class="fa fa-pencil-alt"></i></a>
                        @endif
                      @endif

                      <!--ACCIÓN DE ELIMINAR PRODUCTO -->
                      @if(search_permits('Deliverys','Eliminar todos los usuarios')=="Si")
                        <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_deliverys" onclick="delete_deliverys('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar delivery">
                          <i class="fa fa-trash"></i>
                        </a>
                      @elseif(search_permits('Deliverys','Eliminar mismo usuario')=="Si")
                        @if($k->id_user == \Auth::User()->id)
                          <a class="btn btn-danger btn-xs text-white" data-toggle="modal" data-target="#delete_deliverys" onclick="delete_deliverys('{{$k->id}}')" data-tooltip="tooltip" data-placement="top" title="Eliminar delivery">
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
    $("#deliverys").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  function delete_deliverys(id) {
    $('#delete_id').val(id);
  }
  
</script>
<script type="text/javascript">
  function edit_deliverys(id,delivery, id_agencia) {
    $('#id_delivery_x').val(id);
    $('#mi_delivery_edit').val(delivery);
    $("#id_agencia_edit option[value='"+ id_agencia +"']").attr("selected",true);
  }
</script>
@endsection
