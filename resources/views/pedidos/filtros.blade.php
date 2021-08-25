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
          <li class="breadcrumb-item active">Buscar Pedidos</li>
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
          <form action="{{ route('pedidos.buscar') }}" class="form-horizontal" method="POST" autocomplete="off" name="pedidoFiltroForm" id="pedidoFiltroForm"data-parsley-validate>
            @csrf
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fa fa-filter"></i> Filtro de Pedidos</h3>
              <div class="float-right">
                <a href="{{ route('home') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>                
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar registro</button>
              </div>
            <div class="card-tools">
              
              
            </div>
          </div>
          @if(search_permits('Pedidos','Filtrar Pedidos')=="Si") 
          <div class="card-body">
            <div class="row">
              <div class="col-4">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" required="required" id="fecha" class="form-control" title="Seleccione la fecha en la cual se debe entregar el pedido" value="{{date('Y-m-d')}}">
              </div>
              <div class="col-4">
                
                  <label for="agencia">Agencia</label>
                
                <div class="icheck-success d-inline float-sm-right">
                        <input type="checkbox" name="todas" id="todas" >
                        <label for="todas">Todas:</label>
                </div>
                <select name="id_agencia" id="id_agencia" class="form-control select2bs4" title="Seleccione la agencia la cual debe entregar el pedido" required="required" >
                  @foreach($agencias as $k)
                    <option value="{{$k->id}}">{{$k->nombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-4">
                
                  <label for="estados">Estados</label>
                
                <div class="icheck-success d-inline float-sm-right">
                        <input type="checkbox" name="todos" id="todos" >
                        <label for="todos">Todos:</label>
                </div>
                <select name="id_estado[]" required="required" id="id_estado" class="form-control select2bs4" multiple="multiple" title="Seleccione el(los) estados de los pedidos" >
                  @foreach($estados as $k)
                    <option value="{{$k->id}}">{{$k->estado}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </form>
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
<script type="text/javascript">
  $(document).ready(function () {
  bsCustomFileInput.init();

  });
$("#todas").on('change',function (event) {
  
  if($(this).is(':checked')){
    $("#id_agencia").prop('disabled',true);
  }else{
    $("#id_agencia").prop('disabled',false);
  }
});
$("#todos").on('change',function (event) {
  
  if($(this).is(':checked')){
    $("#id_estado").prop('disabled',true);
  }else{
    $("#id_estado").prop('disabled',false);
  }
});
//--CODIGO PARA CREAR MEDIOS (GUARDAR REGISTRO) ---------------------//
$('#SubmitFiltrar').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var interes=[];
  
  $.ajax({
    
    url: "{{ route('pedidos.buscar') }}",
    method: 'post',
    data: $('#pedidoFiltroForm').serialize(),
    success: function(result) {
      
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        var oTable = $('#medios_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_medios").modal('hide');
        }
      }
    }
  });
});
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
