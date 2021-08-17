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
                          <input type="number" onchange="change_amount(this,{!! $key->id_producto !!})" name="cantidad[]" id="cantidad<?=$key->id_producto?>" value="{{$key->cantidad}}" max="{{$key->disponible}}" min="0" class="form-control">
                        </td>
                        <td>
                          {{$key->producto->detalles}} {{$key->producto->marca}} {{$key->producto->modelo}} {{$key->producto->color}}
                        </td>
                        <td>
                          <input type="number" name="monto_und[]" id="monto_und<?=$key->id_producto?>" step="0.01" value="{{$key->monto_und}}" onchange="change_cost(this,{!! $key->id_producto !!})" min="0" class="form-control" pattern="[0-9]+([,\.][0-9]+)?" formnovalidate="formnovalidate">
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
                      <input type="number" name="monto_descuento" min="0" title="Ingrese el monto del descuento" class="form-control form-control-sm" value="{{$monto_descuento}}"  pattern="[0-9]+([,\.][0-9]+)?" formnovalidate="formnovalidate" onchange="change_monto_descuento(this)">
                    </div>
                    <div class="col-md-4">
                      <label for="descuento_p">Descuento(%)</label>
                      <input type="number" name="porcentaje_descuento" min="0" max="100" title="Ingrese el porcentaje del descuento" class="form-control form-control-sm" value="{{$porcentaje_descuento}}"  pattern="[0-9]+([,\.][0-9]+)?" formnovalidate="formnovalidate" onchange="change_porcentaje_descuento(this)">
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
                            <th style="width:50%">Iva({{$iva->iva}}%):</th>
                            <td>$<span id="iva">{{ number_format($iva_total,2,",",".") }}</span>
                            <input type="hidden" name="iva" id="iva_ip" value="{{$iva_total}}"></td>
                          </tr>                              
                          <tr>
                            <th>Total:</th>
                            <td>$<span id="total">{{ number_format($total_fact,2,",",".") }}</span>
                            <input type="hidden" name="total_ip" id="total_ip" value="{{$total_fact}}"></td>
                          </tr>
                          <!-- en caso de pago con tarjeta de mercado pago -->
                          <tr>
                            <th>Recargo C/Tarjeta:</th>
                            <td>$<span id="recargo_ct">{{ number_format($recargo_ct,2,",",".") }}</span>
                            <input type="hidden" name="recargo_ct_ip" id="recargo_ct_ip" value="{{$recargo_ct}}"></td>
                          </tr>
                          <tr>
                            <th>Nro. de Cuotas:</th>
                            <td><span id="cuotas_ct">&nbsp;{{$cuotas_ct}}</span>
                            <input type="hidden" name="cuotas_ct_ip" id="cuotas_ct_ip" value="{{$cuotas_ct}}"></td>
                          </tr>
                          <tr>
                            <th>Total C/Tarjeta:</th>
                            <td>$<span id="total_ct">{{ number_format($total_ct,2,",",".") }}</span>
                            <input type="hidden" name="total_ct_ip" id="total_ct_ip" value="{{$total_ct}}"></td>
                          </tr>
                          <!-- fin de pago co tarjeta de mercado pago -->
                        </table>
                      </div>
                    </div>                    
                  </div>                  
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-4">
                  <label for="fuente">Fuente:<b style="color: red;">*</b></label>
                  <select name="id_fuente" id="id_fuente" class="form-control" required="required">
                    @foreach($fuentes as $f)
                      <option value="{{$f->id}}">{{$f->fuente}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <div class="icheck-success d-inline">
                    <input type="checkbox" <?php if($recargo_ct > 0){ ?> checked="checked" <?php } ?> name="pago_realizado" id="pago_realizado" onchange="anular_pago_ct()">
                    <label for="pago_realizado">Pagó?:</label>
                  </div>
                  <select name="metodo_pago"  <?php if($recargo_ct == 0){ ?> disabled="disabled" <?php } ?>  id="metodo_pago" class="form-control">
                    <option value="">Seleccione forma de pago...</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="TC-MercadoPago">TC-MercadoPago</option>
                    <!-- <option value="MercadoPago">MercadoPago</option> -->
                    <option value="Efectivo/Transferencia">Efectivo/Transferencia</option>
                    <option value="Transferencia/TC-MercadoPago">Transferencia/TC-MercadoPago</option>
                    <option value="Efectivo/TC-MercadoPago">Efectivo/TC-MercadoPago</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-2" id="col_transferencia"  style="display: none;">
                  <label for="Transferencia">Cód. Transf.:<b style="color: red;">*</b></label>
                  <input type="number" min="0" value="0" placeholder="123456789" title="ingrese el código de la Transferencia" name="codigo_transferencia" id="codigo_transferencia" class="form-control">
                </div>
                <div class="col-2" id="fecha_transferencia" style="display: none">
                  <label for="Fecha">Fecha Transf.:<b style="color: red;">*</b></label>
                  <input type="datetime-local" value="{{date('Y-m-d\TH:i')}}" max="{{date('Y-m-d\TH:i')}}" name="fecha_ptransferencia" id="fecha_ptransferencia" class="form-control">
                </div>
                <div class="col-2" id="col_mercadop" style="display: none;">
                  <label for="Transferencia">Cód. MercadoP.:<b style="color: red;">*</b></label>
                  <input type="number" min="0" value="0" placeholder="123456789" title="ingrese el código de la Transacción por Mercado Pago" name="codigo_mercadopago" id="codigo_mercadopago" class="form-control">
                </div>
                <div class="col-2" id="fecha_mercado" style="display: none">
                  <label for="Fecha">Fecha MercadoP.:<b style="color: red;">*</b></label>
                  <input type="datetime-local" value="{{date('Y-m-d\TH:i')}}" max="{{date('Y-m-d\TH:i')}}" name="fecha_mercadop" id="fecha_mercadop" class="form-control">
                </div>
                <div class="col-2" id="col_tarjeta" style="display: none;">
                  <label for="tc">Cód. P/TC:<b style="color: red;">*</b></label>
                  <input type="number" min="0" value="0" placeholder="123456789" title="ingrese el código de la operación de pago con su tarjeta" name="codigo_tarjeta" id="codigo_tarjeta" class="form-control">
                </div>
                <div class="col-2" id="fecha_tc" style="display: none">
                  <label for="Fecha">Fecha P/TC.:<b style="color: red;">*</b></label>
                  <input type="datetime-local" value="{{date('Y-m-d\TH:i')}}" max="{{date('Y-m-d\TH:i')}}" name="fecha_ptc" id="fecha_ptc" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-4" id="monto_tcmp_v" style="display: none;">
                  <label for="monto_tcmp">Monto a Pagar:<b style="color: red;">*</b></label>
                  <input type="number" min="0" placeholder="12345"  step="0.01" title="ingrese el monto de a pagar por TC-MercadoPago" name="monto_tcmp" id="monto_tcmp" class="form-control" value="{{$total_fact}}">
                </div>
                <div class="col-4" id="medios_v" style="display: none;">
                  <label for="medios_v">Medio de Mercado Pago:<b style="color: red;">*</b></label>
                  <select name="id_medio" id="id_medio" class="form-control" title="Seleccione el Medio de Mercado Pago">
                    <option value="0">Seleccione el Medio</option>
                    @foreach($medios as $m)
                      <option value="{{$m->id}}">{{$m->medio}} - Porcentaje: {{$m->porcentaje}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4" id="cuotas_v" style="display: none;">
                  <label for="cuotas_v">Cuotas:<b style="color: red;">*</b></label>
                  <select name="id_cuota" id="id_cuota" onchange="calcular_recargo(this)" class="form-control" title="Seleccione la cuota del Medio de Mercado Pago">
                    
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-4"  id="recargo_v" style="display: none;">
                  <label for="Recargo">Recargo(%):<b style="color: red;">*</b></label>
                  <input type="number" min="0" value="{{$recargo_ct}}" placeholder="8" title="ingrese el monto de recargo" name="recargo" id="recargo"  class="form-control" readonly="readonly">
                </div>
                <div class="col-4"  id="interes_v" style="display: none;">
                  <label for="interes">Interés por cuota(%):<b style="color: red;">*</b></label>
                  <input type="number" min="0" max="100" value="{{$interes_ct}}" placeholder="2" title="ingrese el porcentaje de Interés" name="interes" id="interes" class="form-control" readonly="readonly">
                </div>
                
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="mb-3">
                  <label for="observacion">Observación:</label>
                  <textarea class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  </div>
                </div>
              </div>
              <br>
              <div class="table-responsive">
                <table class="table table-bordered" id="horarios_pedidos">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-4">
                          <label for="horarios">Horario:<b style="color: red;">*</b></label>
                          <div class="input-group input-group-sm">
                            <input type="datetime-local" value="{{date('Y-m-d\TH:i')}}" min="{{date('Y-m-d\TH:i')}}" name="horarios[]" id="horarios" class="form-control">
                            <span class="input-group-append">
                              <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#" data-tooltip="tooltip" data-placement="top" title="Agregar Horario" id="addHorario"><i class="fa fa-plus"></i></button>
                            </span>
                          </div>
                        </div>
                        <div class="col-8">
                          <label for="horarios">Dirección:<b style="color: red;">*</b></label>
                          <input type="text" name="direccion[]" id="direccion" class="form-control form-control-md" title="Ingrese la dirección en la cual se encuentra en el horario a la izquierda">
                        </div>
                      </div>    
                    </td>
                  </tr>
                </table>
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
var add=0;
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
  //console.log('asas');
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
        //console.log(registro)

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
    //console.log(id_producto+"--"+id_cliente);
    if (id_producto!="" && id_cliente!="") {
      $.get('/pedidos/'+id_producto+'/'+id_cliente+'/llenar_carrito',function (data) {})
        .done(function(data) {
          //console.log(data);        
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
              total_ct=parseFloat(data[i].total_ct.toFixed(2));
              recargo_ct=parseFloat(data[i].recargo_ct.toFixed(2));
              cuotas_ct=data[i].cuotas_ct;
              /*para pagos con mercado */
            $('#invoice').append(
              '<tr>'+
                '<td><a href="#" class="btn btn-primary btn-xs"'+
                ' onclick="cant_disponible('+data[i].id_producto+')">'+
                '<i class="fa fa-list-ol"></i></a></td>'+
                '<td><input type="number" class="form-control" onchange="change_amount(this,'+data[i].id_producto+')" value="'+data[i].cantidad+'" name="amount[]" style="border: 0px; text-align: center;" min="1" max="'+data[i].disponible+'" ></td>'+
                '<td>'+data[i].detalles+' '+data[i].marca+' '+data[i].modelo+' '+data[i].color+'</td>'+
                '<td><input type="number" name="monto_und[]" id="monto_und" value="'+data[i].monto_und+'"  onchange="change_cost(this,'+data[i].id_producto+')" min="0" class="form-control"  pattern="[0-9]+([,\.][0-9]+)?" formnovalidate="formnovalidate"></td>'+
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

          $("#monto_tcmp").val(total_fact);
          $("#total_ct").text(total_ct);
          $("#total_ct_ip").val(total_ct);
          $("#recargo_ct").text(recargo_ct);
          $("#recargo_ct_ip").val(recargo_ct);
          $("#cuotas_ct").text(cuotas_ct);
          $("#cuotas_ct_ip").val(cuotas_ct);         
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
//CAMBIANDO LA CANTIDAD DEL PRODUCTO
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
         
          total_fact=parseFloat(data[i].total_fact);
          descuento_total=parseFloat(data[i].descuento_total);

          total_ct=parseFloat(data[i].total_ct.toFixed(2));
          recargo_ct=parseFloat(data[i].recargo_ct.toFixed(2));
          cuotas_ct=data[i].cuotas_ct;
        $('#total_pp_span'+data[i].id_producto).text(formatNumber(total_pp.toFixed(2)));
      }

      $("#descuento_total_ip").val(descuento_total);
      $("#descuento_total").text(formatNumber(descuento_total.toFixed(2)));
      $("#total").text(formatNumber(total_fact.toFixed(2)));
      $("#total_ip").val(total_fact);
      
      $("#monto_tcmp").val(total_fact);
      $("#total_ct").text(total_ct);
      $("#total_ct_ip").val(total_ct);
      $("#recargo_ct").text(recargo_ct);
      $("#recargo_ct_ip").val(recargo_ct);
      $("#cuotas_ct").text(cuotas_ct);
      $("#cuotas_ct_ip").val(cuotas_ct);               
    });
  }
function remove(id_product){
    $("#remove_id").val(id_product);
  }
//CAMBIANDO EL COSTO DEL PRODUCTO
function change_cost(costo, id_producto){
    var nuevo_costo=costo.value;
    //console.log(costo.target.value);
    $.get('/pedidos/'+nuevo_costo+'/'+id_producto+'/actualizar_costo_producto',function (data) {})
    .done(function(data) {
      var porcentaje_descuento;
      var monto_descuento;
      var total_fact;
      var descuento_total;
      //console.log('asajs');
      for(var i=0; i < data.length; i++){
        var total_pp=parseFloat(data[i].total_pp);
         
          total_fact=parseFloat(data[i].total_fact.toFixed(2));
          descuento_total=parseFloat(data[i].descuento_total.toFixed(2));
          total_ct=parseFloat(data[i].total_ct.toFixed(2));
          recargo_ct=parseFloat(data[i].recargo_ct.toFixed(2));
          cuotas_ct=data[i].cuotas_ct;
        $('#total_pp_span'+data[i].id_producto).text(formatNumber(total_pp.toFixed(2)));
      }

      $("#descuento_total_ip").val(descuento_total);
      $("#descuento_total").text(formatNumber(descuento_total.toFixed(2)));
      $("#total").text(formatNumber(total_fact.toFixed(2)));
      $("#total_ip").val(total_fact);
      $("#monto_tcmp").val(total_fact);
      $("#total_ct").text(total_ct);
      $("#total_ct_ip").val(total_ct);
      $("#recargo_ct").text(recargo_ct);
      $("#recargo_ct_ip").val(recargo_ct);
      $("#cuotas_ct").text(cuotas_ct);
      $("#cuotas_ct_ip").val(cuotas_ct);              
    });
  }
  function change_monto_descuento(monto){
    var nuevo_monto=monto.value;
    
    $.get('/pedidos/'+nuevo_monto+'/actualizar_monto_descuento',function (data) {})
    .done(function(data) {

      $("#descuento_total_ip").val(data[0].descuento_total);
      $("#descuento_total").text(formatNumber(data[0].descuento_total.toFixed(2)));
      $("#total").text(formatNumber(data[0].total_fact.toFixed(2)));
      $("#total_ip").val(data[0].total_fact);
      $("#monto_tcmp").val(data[0].total_fact);
      $("#total_ct").text(formatNumber(data[0].total_ct.toFixed(2)));
      $("#total_ct_ip").val(data[0].total_ct);
      $("#recargo_ct").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#recargo_ct_ip").val(data[0].recargo_ct);
      $("#recargo").val(data[0].recargo_ct.toFixed(2));
      $("#interes").val(data[0].interes_ct);
      $("#cuotas_ct").text(data[0].cuotas_ct);
      $("#cuotas_ct_ip").val(data[0].cuotas_ct);
      $("#iva").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#iva_ip").text(data[0].recargo_ct.toFixed(2));
      
      $("#total_ct").text(formatNumber(data[0].total_ct.toFixed(2)));
      $("#total_ct_ip").val(data[0].total_ct);
      $("#recargo_ct").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#recargo_ct_ip").val(data[0].recargo_ct);
      $("#cuotas_ct").text(formatNumber(data[0].cuotas_ct.toFixed(2)));
      $("#cuotas_ct_ip").val(data[0].cuotas_ct);                   
    });
  }

  function change_porcentaje_descuento(monto){
    var nuevo_monto=monto.value;

    $.get('/pedidos/'+nuevo_monto+'/actualizar_porcentaje_descuento',function (data) {})
    .done(function(data) {

      $("#descuento_total_ip").val(data[0].descuento_total);
      $("#descuento_total").text(formatNumber(data[0].descuento_total.toFixed(2)));
      $("#total").text(formatNumber(data[0].total_fact.toFixed(2)));
      $("#total_ip").val(data[0].total_fact);
      $("#monto_tcmp").val(data[0].total_fact);
      $("#total_ct").text(formatNumber(data[0].total_ct.toFixed(2)));
      $("#total_ct_ip").val(data[0].total_ct);
      $("#recargo_ct").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#recargo_ct_ip").val(data[0].recargo_ct);
      $("#cuotas_ct").text(formatNumber(data[0].cuotas_ct.toFixed(2)));
      $("#cuotas_ct_ip").val(data[0].cuotas_ct);                       
    });
  }

  function formatNumber(num) {
    xnum= num.toString().replace(/\./g,',');
    return xnum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  }
  
    $("#addHorario").on('click',function (event) {
      add++;
      //console.log(add);
      $("#horarios_pedidos").append('<tr id="add'+add+'"><td><div class="row"><div class="col-4"><label for="horarios">Horario:<b style="color: red;">*</b></label><div class="input-group input-group-sm"><input type="datetime-local" value="<?=date('Y-m-d\TH:i')?>" min="<?=date('Y-m-d\TH:i')?>" name="horarios[]" id="horarios'+add+'" class="form-control"><span class="input-group-append"> <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#" data-tooltip="tooltip" data-placement="top" title="Remover Horario" id="remove'+add+'" onclick="remover_horario('+add+')"><i class="fa fa-ban"></i></button></span></div></div><div class="col-8"><label for="horarios">Dirección:<b style="color: red;">*</b></label><input type="text" name="direccion[]" id="direccion'+add+'" class="form-control form-control-md" title="Ingrese la dirección en la cual se encuentra en el horario a la izquierda"></div></div></td></tr>');

    }); 
  function remover_horario(fila) {
    $("#add"+fila).remove();
  }
  $("#pago_realizado").on('change',function (event) {
    if($(this).is(':checked')){
      $("#metodo_pago").removeAttr('disabled');
    }else{
      $("#metodo_pago").attr('disabled',true);
    }
  });
  $("#metodo_pago").on('change',function (event) {
    var opcion=event.target.value;
    switch(opcion){
      case 'TC-MercadoPago':
        $("#col_mercadop").css('display','none');
        $("#col_mercadop").removeAttr('required');
        $("#fecha_mercado").css('display','none');
        $("#fecha_mercadop").removeAttr('required');

        $("#col_transferencia").css('display','none');
        $("#col_transferencia").removeAttr('required');
        $("#fecha_transferencia").css('display','none');
        $("#fecha_ptransferencia").removeAttr('required');

        $("#col_tarjeta").css('display','block');
        $("#col_tarjeta").attr('required',true);
        $("#fecha_tc").css('display','block');
        $("#fecha_ptc").attr('required',true);  
        
        $("#recargo_v").css('display','block');
        $("#interes_v").css('display','block');
        $("#cuotas_v").css('display','block');
        $("#recargo_v").attr('required',true);
        $("#interes_v").attr('required',true);
        $("#cuotas_v").attr('required',true);

        $("#monto_tcmp_v").css('display','block');
        $("#monto_tcmp").attr('readonly',true);
        $("#medios_v").css('display','block');
        $("#cuotas_v").css('display','block');
      break;
      case 'Transferencia':
        $("#col_transferencia").css('display','block');
        $("#col_transferencia").attr('required',true);
        $("#fecha_transferencia").css('display','block');
        $("#fecha_ptransferencia").attr('required',true);

        $("#col_mercadop").css('display','none');
        $("#col_mercadop").removeAttr('required');
        $("#fecha_mercado").css('display','none');
        $("#fecha_mercadop").removeAttr('required');

        $("#col_tarjeta").css('display','none');
        $("#col_tarjeta").removeAttr('required');
        $("#fecha_tc").css('display','none');
        $("#fecha_ptc").removeAttr('required'); 

        $("#recargo_v").css('display','none');
        $("#interes_v").css('display','none');
        $("#cuotas_v").css('display','none');
        $("#recargo_v").removeAttr('required');
        $("#interes_v").removeAttr('required');
        $("#cuotas_v").removeAttr('required');

        $("#monto_tcmp_v").css('display','none');
        $("#medios_v").css('display','none');
        $("#cuotas_v").css('display','none');
        $("#monto_tcmp").removeAttr('readonly');
        anular_pago_ct();
      break;
      case 'Transferencia/TC-MercadoPago':
        $("#col_transferencia").css('display','block');
        $("#col_transferencia").attr('required',true);
        $("#fecha_transferencia").css('display','block');
        $("#fecha_ptransferencia").attr('required',true);

        $("#col_mercadop").css('display','block');
        $("#col_mercadop").attr('required',true);
        $("#fecha_mercado").css('display','block');
        $("#fecha_mercadop").attr('required',true);

        $("#col_tarjeta").css('display','none');
        $("#col_tarjeta").removeAttr('required');
        $("#fecha_tc").css('display','none');
        $("#fecha_ptc").removeAttr('required'); 

        $("#recargo_v").css('display','block');
        $("#interes_v").css('display','block');
        $("#cuotas_v").css('display','block');
        $("#recargo_v").attr('required');
        $("#interes_v").attr('required');
        $("#cuotas_v").attr('required');


        $("#monto_tcmp_v").css('display','block');
        $("#monto_tcmp").removeAttr('readonly');
        $("#medios_v").css('display','block');
        $("#cuotas_v").css('display','block');
      break;
      case 'Efectivo/Transferencia':
        $("#col_transferencia").css('display','block');
        $("#col_transferencia").attr('required',true);
        $("#fecha_transferencia").css('display','block');
        $("#fecha_ptransferencia").attr('required',true);        

        $("#col_mercadop").css('display','none');
        $("#col_mercadop").removeAttr('required');
        $("#fecha_mercado").css('display','none');
        $("#fecha_mercadop").removeAttr('required');

        $("#col_tarjeta").css('display','none');
        $("#col_tarjeta").removeAttr('required');
        $("#fecha_tc").css('display','none');
        $("#fecha_ptc").removeAttr('required');  

        $("#recargo_v").css('display','none');
        $("#interes_v").css('display','none');
        $("#cuotas_v").css('display','none');
        $("#recargo_v").removeAttr('required');
        $("#interes_v").removeAttr('required');
        $("#cuotas_v").removeAttr('required');


        $("#monto_tcmp_v").css('display','none');
        $("#monto_tcmp").removeAttr('readonly');
        $("#medios_v").css('display','none');
        $("#cuotas_v").css('display','none');

        anular_pago_ct();
      break;
      case 'Efectivo/TC-MercadoPago':
        $("#col_mercadop").css('display','block');
        $("#col_mercadop").attr('required',true);
        $("#fecha_mercado").css('display','block');
        $("#fecha_ptc").attr('required',true);

        $("#col_transferencia").css('display','none');
        $("#col_transferencia").removeAttr('required');
        $("#fecha_transferencia").css('display','none');
        $("#fecha_ptransferencia").removeAttr('required');

        $("#col_tarjeta").css('display','none');
        $("#col_tarjeta").removeAttr('required'); 
        $("#fecha_tc").css('display','none');
        $("#fecha_ptc").removeAttr('required'); 

        $("#recargo_v").css('display','block');
        $("#interes_v").css('display','block');
        $("#cuotas_v").css('display','block');
        $("#recargo_v").attr('required');
        $("#interes_v").attr('required');
        $("#cuotas_v").attr('required');


        $("#monto_tcmp_v").css('display','block');
        $("#monto_tcmp").removeAttr('readonly');
        $("#medios_v").css('display','block');
        $("#cuotas_v").css('display','block');

      break;
      
      default:
        $("#col_transferencia").css('display','none');
        $("#col_transferencia").removeAttr('required');
        $("#fecha_transferencia").css('display','none');
        $("#fecha_ptransferencia").removeAttr('required');

        $("#col_tarjeta").css('display','none');
        $("#col_tarjeta").removeAttr('required');
        $("#fecha_tc").css('display','none');
        $("#fecha_ptc").removeAttr('required');  

        $("#col_mercadop").css('display','none');
        $("#col_mercadop").removeAttr('required');
        $("#fecha_mercado").css('display','none');
        $("#fecha_mercadop").removeAttr('required');
        
        $("#recargo_v").css('display','none');
        $("#interes_v").css('display','none');
        $("#cuotas_v").css('display','none');
        $("#recargo_v").removeAttr('required');
        $("#interes_v").removeAttr('required');
        $("#cuotas_v").removeAttr('required');


        $("#monto_tcmp_v").css('display','none');
        $("#monto_tcmp").removeAttr('readonly');
        $("#medios_v").css('display','none');
        $("#cuotas_v").css('display','none');

        anular_pago_ct();
      break;

    }
  });
function calcular_recargo(id_cuota) {
  //console.log(id_cuota.value);
    var monto=$("#monto_tcmp").val();
    $.get('/pedidos/'+id_cuota.value+'/'+monto+'/calcular_recargo',function (data) {})
    .done(function(data) {
      
      $("#total_ct").text(formatNumber(data[0].total_ct.toFixed(2)));
      $("#total_ct_ip").val(data[0].total_ct);
      $("#recargo_ct").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#recargo_ct_ip").val(data[0].recargo_ct);
      $("#recargo").val(data[0].recargo_ct.toFixed(2));
      $("#interes").val(data[0].interes_ct);
      $("#cuotas_ct").text(data[0].cuotas_ct);
      $("#cuotas_ct_ip").val(data[0].cuotas_ct);
      $("#iva").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#iva_ip").text(data[0].recargo_ct.toFixed(2));
      $("#monto_ct").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#monto_ct_ip").text(data[0].recargo_ct.toFixed(2));
    });
}
$("#id_medio").on('change',function (event) {
    var id_medio=event.target.value;
    //console.log(id_producto+"--"+id_cliente);
    if (id_producto!="" && id_cliente!="") {
      $.get('/medios/'+id_medio+'/buscar_cuotas',function (data) {})
        .done(function(data) {
            if (data.length > 0) {
              $("#id_cuota").empty();
              $("#id_cuota").append("<option value='0'>Seleccione la cantidad de cuotas</option>");
              for(var i=0; i < data.length; i++){
                $("#id_cuota").append("<option value='"+data[i].id+"'>"+data[i].cant_cuota+" - Interes: "+data[i].interes+"</option>");
              }
            }
        });
      }
    });
  function anular_pago_ct() {
    $.get('/pedidos/0/0/calcular_recargo',function (data) {})
    .done(function(data) {
      
      $("#total_ct").text(formatNumber(data[0].total_ct.toFixed(2)));
      $("#total_ct_ip").val(data[0].total_ct);
      $("#recargo_ct").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#recargo_ct_ip").val(data[0].recargo_ct);
      $("#recargo").val(data[0].recargo_ct.toFixed(2));
      $("#interes").val(data[0].interes_ct);
      $("#cuotas_ct").text(data[0].cuotas_ct);
      $("#cuotas_ct_ip").val(data[0].cuotas_ct);
      $("#iva").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#iva_ip").text(data[0].recargo_ct.toFixed(2));
      $("#monto_ct").text(formatNumber(data[0].recargo_ct.toFixed(2)));
      $("#monto_ct_ip").text(data[0].recargo_ct.toFixed(2));

      $("#col_transferencia").css('display','none');
        $("#col_transferencia").removeAttr('required');
        $("#fecha_transferencia").css('display','none');
        $("#fecha_ptransferencia").removeAttr('required');

        $("#col_tarjeta").css('display','none');
        $("#col_tarjeta").removeAttr('required');
        $("#fecha_tc").css('display','none');
        $("#fecha_ptc").removeAttr('required');  

        $("#col_mercadop").css('display','none');
        $("#col_mercadop").removeAttr('required');
        $("#fecha_mercado").css('display','none');
        $("#fecha_mercadop").removeAttr('required');
        
        $("#recargo_v").css('display','none');
        $("#interes_v").css('display','none');
        $("#cuotas_v").css('display','none');
        $("#recargo_v").removeAttr('required');
        $("#interes_v").removeAttr('required');
        $("#cuotas_v").removeAttr('required');


        $("#monto_tcmp_v").css('display','none');
        $("#medios_v").css('display','none');
        $("#cuotas_v").css('display','none');
    });
  }
</script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@endsection
