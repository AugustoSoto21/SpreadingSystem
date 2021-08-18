<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\PartidosController;
use App\Http\Controllers\ZonasController;
use App\Http\Controllers\AgenciasController;
use App\Http\Controllers\FuentesController;
use App\Http\Controllers\DeliverysController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\IvaController;
use App\Http\Controllers\MedioController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware('guest')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});

Auth::routes();
Route::group(['middleware' => ['web', 'auth']], function() {
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::resource('/estados',EstadosController::class);
	Route::resource('/partidos',PartidosController::class);
	Route::resource('/zonas',ZonasController::class);
	Route::resource('/agencias',AgenciasController::class);
	Route::resource('/fuentes',FuentesController::class);
	Route::resource('/deliverys',DeliverysController::class);
	Route::resource('/clientes',ClientesController::class);

	Route::get('productos/imagenes',[ProductosController::class,'imagenes'])->name('productos.imagenes');
	Route::post('/productos/registrar',[ProductosController::class,'registrar'])->name('productos.registrar');
	Route::resource('/productos',ProductosController::class);
	Route::post('/productos/eliminar_imagen',[ProductosController::class,'eliminar_imagen'])->name('eliminar_imagen');
	Route::post('/productos/mostrar', [ProductosController::class,'mostrar'])->name('productos.mostrar_producto');
	Route::get('/buscar_categorias',[ProductosController::class, 'buscar_categorias']);
	Route::resource('/categorias',CategoriasController::class);

	Route::get('/stocks/historial', [InventarioController::class, 'historial'])->name('stocks.historial');
	Route::post('/stocks/registrar', [InventarioController::class, 'registrar'])->name('stocks.registrar');
	Route::get('stocks/historial/{id}/editar', [InventarioController::class, 'editar'])->name('historial.editar');
	Route::resource('/stocks',InventarioController::class);

	Route::get('/pedidos/{id_producto}/{id_cliente}/llenar_carrito',[PedidosController::class,'llenar_carrito']);
	Route::get('/pedidos/{nueva_cantidad}/{id_producto}/actualizar_cantidad_producto',[PedidosController::class,'actualizar_cantidad_producto']);
	Route::get('/pedidos/{nuevo_costo}/{id_producto}/actualizar_costo_producto',[PedidosController::class,'actualizar_costo_producto']);
	Route::get('/pedidos/{nuevo_monto}/actualizar_monto_descuento',[PedidosController::class,'actualizar_monto_descuento']);
	Route::get('/pedidos/{nuevo_monto}/actualizar_porcentaje_descuento',[PedidosController::class,'actualizar_porcentaje_descuento']);
	Route::get('/pedidos/{id_cuota}/{monto}/calcular_recargo',[PedidosController::class,'calcular_recargo']);
	Route::post('/pedidos/remove',[PedidosController::class,'remove'])->name('pedidos.remove');
	Route::get('/pedidos/{id_zona}/buscar_agencias_tarifas',[PedidosController::class,'buscar_agencias_tarifas']);

	Route::resource('/pedidos',PedidosController::class);
	Route::get('/buscar_clientes',[ClientesController::class, 'buscar_clientes']);
	Route::get('/buscar_productos',[ProductosController::class, 'buscar_productos']);
	Route::get('/buscar_stock/{id_producto}/{opcion}/producto',[ProductosController::class, 'buscar_stock_producto']);

	Route::resource('/iva',IvaController::class);
	Route::get('/medios/{id_medio}/buscar_cuotas',[MedioController::class,'buscar_cuotas']);
		Route::resource('/medios',MedioController::class);
});