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
    @include('agencias.partials.create')
    @include('productos.partials.create')
    @include('categorias.partials.create')
    @include('stocks.partials.edit_historial')
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
              <button id="createNewProducto" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Producto</button>
              <button id="createNewAgencia" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Agencia</button>
            </div>
          </div>
          @if(search_permits('Stocks','Ver mismo usuario')=="Si" || search_permits('Stocks','Ver todos los usuarios')=="Si" || search_permits('Stocks','Editar mismo usuario')=="Si" || search_permits('Stocks','Editar todos los usuarios')=="Si" || search_permits('Stocks','Eliminar mismo usuario')=="Si" || search_permits('Stocks','Eliminar todos los usuarios')=="Si")

          <div class="card-body">
            <table id="historial_table" class="table-responsive table table-bordered table-striped table-sm" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Agencia</th>
                  <th>Locker</th>
                  <th>Historial</th>
                  <th>Cantidad</th>
                  <th>Acciones</th>
                </tr>
                <form name="historial" id="historial"  data-parsley-validate method="POST" >

                <tr>
                  <th>
                    <input type="date" name="fecha_new" required="required" value="{{date('Y-m-d')}}" class="form-control form-control-sm" id="fecha_new" max="{{date('Y-m-d')}}">
                  </th>
                  <th>
                    <select name="id_agencia_new" id="id_agencia_new" class="select2 form-control form-control-sm" style="width: 100%;">
                        @foreach($agencias as $a)
                        <option value="{{$a->id}}">{{$a->nombre}}</option>
                        @endforeach    
                    </select>
                  </th>
                  <th>
                    <select name="locker_new" id="locker_new" class="form-control form-control-sm">
                      <option value="SIN PROBAR">SIN PROBAR</option>
                      <option value="STOCK">STOCK</option>
                      <option value="FALLA">FALLA</option>
                      <option value="CAMBIO">CAMBIO</option>
                    </select>
                  </th>
                  <th>
                    <select name="id_producto_new" id="id_producto_new" class="form-control form-control-sm select2" style="width: 100%;">
                      @foreach($productos as $p)
                        <option value="{{$p->id}}">{{$p->detalles}} {{$p->marca}} {{$p->modelo}} {{$p->color}}</option>
                      @endforeach
                    </select>
                  </th>
                  <th>
                    <input type="number" name="cantidad_new" id="cantidad_new" class="form-control form-control-sm" value="0" min="0">
                  </th>
                  <th>
                    <button type="submit" id="SubmitCreateHistorial" class="btn btn-info btn-sm"><i class="fa fa-save"></i> Registrar</button>
                  </th>
                </tr>
              </form>
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
    autoWidth: true,
    ajax: {
      url:"{{ url('stocks/historial') }}"
   },
    columns: [
      { data: 'fecha', name: 'fecha', orderable: false },
      { data: 'id_agencia', name: 'id_agencia', orderable: false },
      { data: 'locker', name: 'locker', orderable: false },
      { data: 'id_producto', name: 'id_producto', orderable: false },
      { data: 'cantidad', name: 'cantidad', orderable: false },
      {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });
});
//--CODIGO PARA CREAR HISTORIAL (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateHistorial').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('stocks.registrar') }}",
    method: 'post',
    data: {
      fecha: $('#fecha_new').val(),
      id_agencia: $('#id_agencia_new').val(),
      locker: $('#locker_new').val(),
      id_producto: $('#id_producto_new').val(),
      cantidad: $('#cantidad_new').val(),
    },
    success: function(result) {
      console.log(result);
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        var oTable = $('#historial_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_estados").modal('hide');
        }
      }
    }
  });
});
//--CODIGO PARA EDITAR HISTORIAL ---------------------//
$('body').on('click', '#editHistorials', function () {
  var id = $(this).data('id');
  $.ajax({
    method:"GET",
    url: "historial/"+id+"/editar",
    dataType: 'json',
    success: function(data){
      $('#edit_historials').modal({backdrop: 'static', keyboard: true, show: true});
      $('.alert-danger').hide();
      $('#id_historial_edit').val(id);

      $('#fecha_edit').text($('#fecha'+id).val());
      $('#fecha_e').val($('#fecha'+id).val());

      $('#agencia_edit').text($('#id_agencia'+id).val());
      $('#id_agencia_e').val($('#id_agencia'+id).val());

      $('#locker_edit').text($('#locker'+id).val());
      $('#locker_e').val($('#locker'+id).val());

      $('#producto_edit').text($('#id_producto'+id).val());
      $('#id_producto_e').val($('#id_producto'+id).val());

      $('#cantidad_edit').text($('#cantidad'+id).val());
      $('#cantidad_e').val($('#cantidad'+id).val());
      
    }
  });
});
//--CODIGO PARA UPDATE HISTORIAL ---------------------//
$('#SubmitEditHistorial').click(function(e) {
  e.preventDefault();
  var id = $('#id_historial_edit').val();
  $.ajax({
    method:'PUT',
    url: "estados/"+id+"",
    data: {
      id_estado: $('#id_estado_edit').val(),
      estado: $('#estado_edit').val(),
      color: $('#color_edit').val()
    },
    success: (data) => {
      if(data.errors) {
        $('.alert-danger').html('');
        $.each(data.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        var oTable = $('#estados_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( data.titulo ,  data.message ,  data.icono );
        if (data.icono=="success") {
          $("#edit_estados").modal('hide');
        }
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
//--CODIGO PARA CREAR AGENCIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewAgencia').click(function () {
  $('#agenciaForm').trigger("reset");
  $('#create_agencias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR AGENCIAS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateAgencia').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('agencias.store') }}",
    method: 'post',
    data: {
      nombre: $('#nombre').val(),
      almacen: $('#almacen').val()
    },
    success: function(result) {
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        //console.log(result.agencias.length);
        if(result.agencias.length > 0){
            $("#id_agencia_new").empty();
            for(var i=0 ; i < result.agencias.length ; i++){
              //console.log(result.agencias[i].nombre);
              $("#id_agencia_new").append("<option value='"+result.agencias[i].id+"'>"+result.agencias[i].nombre+" </option>");
            } 
          }
        $('.alert-danger').hide();
        var oTable = $('#historial_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_agencias").modal('hide');
        }
      }
    }
  });
});
//--CODIGO PARA CREAR PRODUCTOS (LEVANTAR EL MODAL) ---------------------//
$('#createNewProducto').click(function () {
  $('#agenciaForm').trigger("reset");
  $('#create_productos').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR PRODUCTOS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateProducto').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('productos.registrar') }}",
    method: 'post',
    data: {
      detalles: $('#detalles').val(),
      modelo: $('#modelo').val(),
      marca: $('#marca').val(),
      color: $('#color').val(),
      id_categoria: $('#id_categoria').val(),
    },
    success: function(result) {
      //console.log(result);
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        //console.log(result.productos.length);
        if(result.productos.length > 0){
            $("#id_producto_new").empty();
            for(var i=0 ; i < result.productos.length ; i++){
              //console.log(result.productos[i]);
              $("#id_producto_new").append("<option value='"+result.productos[i].id+"'>"+result.productos[i].detalles+" "+result.productos[i].modelo+" "+result.productos[i].marca+""+result.productos[i].color+"</option>");
            } 
          }
        $('.alert-danger').hide();
        var oTable = $('#historial_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_productos").modal('hide');
          
        }
      }
    }
  });
});
//--CODIGO PARA CREAR CATEGORIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewCategoria').click(function () {
  $('#categoriaForm').trigger("reset");
  $('#create_categorias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR CATEGORIAS (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateCategoria').click(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "{{ route('categorias.store') }}",
    method: 'post',
    data: {
      categoria: $('#categoria').val()
    },
    success: function(result) {
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
         console.log(result.categorias.length);
        if(result.categorias.length > 0){
            $("#id_categoria").empty();
            for(var i=0 ; i < result.categorias.length ; i++){
              //console.log(result.categorias[i]);
              $("#id_categoria").append("<option value='"+result.categorias[i].id+"'>"+result.categorias[i].categoria+"</option>");
            } 
          }
        $('.alert-danger').hide();
        var oTable = $('#categorias_table').dataTable();
        oTable.fnDraw(false);
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_categorias").modal('hide');
        }
      }
    }
  });
});


</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
