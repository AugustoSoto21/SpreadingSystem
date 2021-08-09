@extends('layouts.app')
@section('title') Registro de Pedido @endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><i class="nav-icon fa fa-shopping-basket"></i> Pedidos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Pedidos</a></li>
          <li class="breadcrumb-item active">Registro de Pedido</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    @include('categorias.partials.create')
    @include('clientes.partials.create')
    @include('pedidos.partials.remove')
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <form action="{{ route('productos.store') }}" class="form-horizontal" method="POST" autocomplete="off" name="productoForm" id="productoForm" enctype="Multipart/form-data" data-parsley-validate>
            @csrf
            <div class="card-header">
              <h3 class="card-title" style="margin-top: 5px;"><i class="nav-icon fa fa-shopping-basket"></i> Registro de pedido</h3>
              <div class="float-right">
                <a href="{{ route('pedidos.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Regresar</a>                
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar registro</button>
              </div>
            </div>
            <div class="card-body">
              <p align="center"><small>Todos los campos <b style="color: red;">*</b> son requeridos.</small></p>
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;" id="message_error">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="id_cliente">Cliente <b style="color: red;">*</b></label>
                  <div class="input-group input-group-sm">
                    <select name="id_cliente" id="id_cliente" class="form-control select2bs4 form-control-sm">
                    </select>
                    @if(search_permits('Clientes','Registrar')=="Si")
                    <span class="input-group-append">
                      <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#create_clientes" data-tooltip="tooltip" data-placement="top" title="Registrar Cliente" id="createNewCliente"><i class="fa fa-plus"> Agregar!</i></button>
                    </span>
                    @endif
                  </div>
                  @error('id_cliente')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="id_producto">Productos <b style="color: red;">*</b></label>
                    <select name="id_producto" id="id_producto" class="form-control select2bs4 form-control-sm">
                    </select>
                  </div>
                  @error('id_producto')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
                <!-- Table row -->
              <div class="row">
                <div class="col-md-12 table-responsive">
                  <table class="table table-striped table-sm" style="text-align: center; font-size: 14px;">
                    <thead>
                    <tr>
                      <th></th>
                      <th>Cantidad</th>
                      <th>Producto</th>
                      <th>Valor unitario</th>
                      <th title="Total Por Producto">Total P/P</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody id="invoice">
                      @foreach($carrito as $key)
                      
                      <tr>
                        <td>
                            <a href="#" title="Consultar Disponibilidad" class="btn btn-primary btn-xs" onclick="cant_disponible('{{ $key->id_producto }}')"><i class="fa fa-list-ol"></i></a>
                        </td>
                        <td>
                          <input type="number" onchange="change_amount(this,{!! $key->id_producto !!})" name="cantidad[]" id="cantidad" value="{{$key->cantidad}}" max="{{$key->disponible}}" min="0" class="form-control">
                        </td>
                        <td>
                          {{$key->producto->detalles}} {{$key->producto->marca}} {{$key->producto->modelo}} {{$key->producto->color}}
                        </td>
                        <td>
                          <input type="number" name="monto_und[]" id="monto_und" step="0.01" value="{{$key->monto_und}}" min="0" class="form-control">
                        </td>
                        <td>
                          <input type="hidden" name="total_pp[]" id="total_pp<?=$key->id_producto?>" value="{{$key->total_pp}}" min="0" class="form-control">
                          <span id="total_pp_span<?=$key->id_producto?>">{{ number_format($key->total_pp,2,",",".") }}</span>
                        </td>
                        <td>
                          <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#remove_products" onclick="remove('{{$key->id}}')"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div><hr>
              <div class="row">
                <div class="col-7">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="descuento_m">Descuento($)</label>
                      <input type="number" name="monto_descuento" min="0" title="Ingrese el monto del descuento" class="form-control form-control-sm" value="{{$monto_descuento}}">
                    </div>
                    <div class="col-md-4">
                      <label for="descuento_p">Descuento(%)</label>
                      <input type="number" name="porcentaje_descuento" min="0" max="100" title="Ingrese el porcentaje del descuento" class="form-control form-control-sm" value="{{$porcentaje_descuento}}">
                    </div>                    
                    <div class="col-md-4">
                      <label for="horarios">Horarios <b style="color: red;">*</b></label>
                      <div class="input-group input-group-sm">
                        <input type="datetime-local" value="{{date('Y-m-d\TH:i')}}" min="{{date('Y-m-d\TH:i')}}" name="horarios[]" id="horarios" class="form-control">
                        <span class="input-group-append">
                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#" data-tooltip="tooltip" data-placement="top" title="Agregar Horario" id="createNewHorario"><i class="fa fa-plus"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-5">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-sm">
                          <tr>
                            <th style="width:50%">Descuento($):</th>
                            <td>$<span id="descuento_total">{{ number_format($descuento_total,2,",",".") }}</span>
                            <input type="hidden" name="descuento_total" id="descuento_total_ip" value="{{$descuento_total}}"></td>
                          </tr>                            
                          <tr>
                            <th>Total:</th>
                            <td>$<span id="total">{{ number_format($total_fact,2,",",".") }}</span>
                            <input type="hidden" name="total_ip" id="total_ip" value="{{$total_fact}}"></td>
                          </tr>
                        </table>
                      </div>
                    </div>                    
                  </div>                  
                </div>
              </div>                  
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
cliente_data();
producto_data();
//--CODIGO PARA CREAR CATEGORIAS (LEVANTAR EL MODAL) ---------------------//
$('#createNewCategoria').click(function () {
  $('#categoriaForm').trigger("reset");
  $('#create_categorias').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});

function cliente_data() {
  $.ajax({
    type:"GET",
    url: "{{ url('buscar_clientes') }}",
    dataType: 'json',
    success: function(response){
      $('#id_cliente').empty();
      $.each(response, function(key, registro) {
        $('#id_cliente').append('<option value='+registro.id+'>'+registro.nombres+' '+registro.apellidos+' '+registro.celular+'</option>');
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de clientes.", icon:  "error"});
    }
  });
}
function producto_data() {
  $.ajax({
    type:"GET",
    url: "{{ url('buscar_productos') }}",
    dataType: 'json',
    success: function(response){
      $('#id_producto').empty();
      $('#id_producto').append("<option value='0'>Seleccione un producto</option>");
      $.each(response, function(key, registro) {
        producto_stock(registro.id);
          
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de productos.", icon:  "error"});
    }
  });
}

$('#createNewCliente').click(function () {
  $('#clienteForm').trigger("reset");
  $('#create_clientes').modal({backdrop: 'static', keyboard: true, show: true});
  $('.alert-danger').hide();
});
//--CODIGO PARA CREAR PBX (GUARDAR REGISTRO) ---------------------//
$('#SubmitCreateCliente').click(function(e) {
  console.log('asas');
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
    url: "{{ route('clientes.store') }}",
    method: 'post',
    data: {
      nombres: $('#nombres').val(),
      apellidos: $('#apellidos').val(),
      celular: $('#celular').val(),
      direccion: $('#direccion').val(),
      localidad: $('#localidad').val(),
    },
    success: function(result) {
      if(result.errors) {
        $('.alert-danger').html('');
        $.each(result.errors, function(key, value) {
          $('.alert-danger').show();
          $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
        });
      } else {
        $('.alert-danger').hide();
        Swal.fire ( result.titulo ,  result.message ,  result.icono );
        if (result.icono=="success") {
          $("#create_clientes").modal('hide');
          cliente_data();
        }
      }
    }
  });
});

function producto_stock(id) {
  $.ajax({
    type:"GET",
    url: "../buscar_stock/"+id+"/1/producto",
    dataType: 'json',
    success: function(response){
      $.each(response, function(key, registro) {
        var total_stock;
        var total_disponible;

           if(registro.total_stock){
              total_stock=registro.total_stock;
              total_disponible=registro.total_disponible;
              $('#id_producto').append("<option value='"+registro.id+"'>"+registro.detalles+" "+registro.modelo+" "+registro.marca+" "+registro.color+" Stock: "+total_stock+" - Disponible: "+total_disponible+" </option>");
           }
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de stocks.", icon:  "error"});
    }
  });
}
function cant_disponible(id){

$.ajax({
    type:"GET",
    url: "../buscar_stock/"+id+"/2/producto",
    dataType: 'json',
    success: function(response){
      $.each(response, function(key, registro) {
        console.log(registro)

           if(registro.total_stock){
            if(registro.marca){
              var marca=registro.marca;
            }else{
              var marca="";
            }
              Swal.fire({
                  title: ""+registro.detalles+" "+registro.marca+" "+registro.modelo+" "+registro.color+"",
                  text:  "Cantidad disponible: "+registro.total_disponible+"",
                  icon:  "success",
              });
           }
      });
    },
    error: function (data) {
      Swal.fire({title: "Error del servidor", text: "Consulta de Disponible.", icon:  "error"});
    }
  });   
  }
//---SELECCIONANDO PRODUCTO PARA CARRITO
$("#id_producto").on('select2:select',function (event) {
    var id_producto=event.target.value;
    var id_cliente=document.getElementById("id_cliente").value;
    console.log(id_producto+"--"+id_cliente);
    if (id_producto!="" && id_cliente!="") {
      $.get('/pedidos/'+id_producto+'/'+id_cliente+'/llenar_carrito',function (data) {})
        .done(function(data) {
          console.log(data);        
          /*if($("#general_discount").is(':disabled')){
            $("#general_discount").removeAttr('disabled');
          }*/
          $('#invoice').empty();
            
            var porcentaje_descuento;
            var monto_descuento;
            var total_fact;
            var descuento_total;

            for(var i=0; i < data.length; i++){
              var total_pp=parseFloat(data[i].total_pp.toFixed(2));
              porcentaje_descuento=parseFloat(data[i].porcentaje_descuento.toFixed(2));
              monto_descuento=parseFloat(data[i].monto_descuento.toFixed(2));
              total_fact=parseFloat(data[i].total_fact.toFixed(2));
              descuento_total=parseFloat(data[i].descuento_total.toFixed(2));
            $('#invoice').append(
              '<tr>'+
                '<td><a href="#" class="btn btn-primary btn-xs"'+
                ' onclick="cant_disponible('+data[i].id_producto+')">'+
                '<i class="fa fa-list-ol"></i></a></td>'+
                '<td><input type="number" class="form-control" onchange="change_amount(this,'+data[i].id_producto+')" value="'+data[i].cantidad+'" name="amount[]" style="border: 0px; text-align: center;" min="1" max="'+data[i].disponible+'" ></td>'+
                '<td>'+data[i].detalles+' '+data[i].marca+' '+data[i].modelo+' '+data[i].color+'</td>'+
                '<td><input type="number" name="monto_und[]" id="monto_und" value="'+data[i].monto_und+'" min="0" class="form-control"></td>'+
                '<td><td><input type="hidden" name="total_pp[]" id="total_pp'+data[i].id_producto+'" value="'+data[i].total_pp+'" min="0" class="form-control"><span id="total_pp_span'+data[i].id_producto+'">'+total_pp+'</span></td>'+
                '<td><a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#remove_products" onclick="remove('+data[i].id+')"><i class="fa fa-trash"></i></a></td>'+
              +'</tr>'
            );
            
            
          }
          $("#monto_descuento").val(monto_descuento);
          $("#porcentaje_descuento").val(porcentaje_descuento);
          $("#descuento_total_ip").val(descuento_total);
          $("#descuento_total").text(descuento_total);
          $("#total").text(total_fact);
          $("#total_ip").val(total_fact);
         
          producto_data();
        });
        
    } else {
      swal({
        title: "Error",
        text:  "Debe seleccionar un cliente",
        icon:  "error",
      });
      document.getElementById("id_producto").value = "";
    }
  });
function change_amount(cantidad, id_producto){
    var nueva_cantidad=cantidad.value;
    //console.log('llego'+new_amount+'---'+id_product)
    $.get('/pedidos/'+nueva_cantidad+'/'+id_producto+'/actualizar_cantidad_producto',function (data) {})
    .done(function(data) {
      var porcentaje_descuento;
      var monto_descuento;
      var total_fact;
      var descuento_total;

      for(var i=0; i < data.length; i++){
        var total_pp=parseFloat(data[i].total_pp.toFixed(2));
         
          total_fact=parseFloat(data[i].total_fact.toFixed(2));
          descuento_total=parseFloat(data[i].descuento_total.toFixed(2));
        $('#total_pp_span'+data[i].id_producto).text(total_pp);
      }

      $("#descuento_total_ip").val(descuento_total);
      $("#descuento_total").text(descuento_total.toFixed(2));
      $("#total").text(total_fact.toFixed(2));
      $("#total_ip").val(total_fact);
            
    });
  }
function remove(id_product){
    $("#remove_id").val(id_product);
  }
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
