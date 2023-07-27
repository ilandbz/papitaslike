<?php

use App\Http\Controllers\EntidadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('login', [LoginController::class, 'autenticar'])->name('acceder');

Route::get('login', function () {
    return view('login');

})->name('login');

Route::group(['prefix' => 'usuarios', 'middleware' => 'auth'], function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::post('/', [UsuarioController::class, 'store']);    
    Route::get('/todos', [UsuarioController::class, 'lista']);
    Route::post('/eliminar', [UsuarioController::class, 'destroy']);
    Route::get('/obtener', [UsuarioController::class, 'obtenerusuario']);
    Route::post('/resetear', [UsuarioController::class, 'resetearusuario']);
    Route::get('/cambiar-estado', [UsuarioController::class, 'cambiarestado']);
});

Route::group(['prefix' => 'productos', 'middleware' => 'auth'], function () {
    Route::get('/', [ProductoController::class, 'index']);
    Route::post('/', [ProductoController::class, 'store']);
    Route::get('/todos', [ProductoController::class, 'lista']);
    Route::get('/obtener', [ProductoController::class, 'show']);
    Route::post('/eliminar', [ProductoController::class, 'destroy']);
});

Route::group(['prefix' => 'entidad', 'middleware' => 'auth'], function () {
    Route::get('/proveedor', [EntidadController::class, 'proveedor']);
    Route::get('/distribuidor', [EntidadController::class, 'distribuidor']);
    Route::post('/guardar', [EntidadController::class, 'store']);
    Route::get('/Proveedor-todos', [EntidadController::class, 'listaproveedores']);
    Route::get('/Distribuidor-todos', [EntidadController::class, 'listadistribuidores']);
    Route::get('/obtener', [EntidadController::class, 'show']);
    Route::post('/eliminar', [EntidadController::class, 'destroy']);
});
Route::group(['prefix' => 'orden', 'middleware' => 'auth'], function () {
    Route::get('/pedido', [OrdenController::class, 'pedido']);
    Route::get('/venta', [OrdenController::class, 'venta']);
    Route::post('/', [OrdenController::class, 'store']);
    Route::post('/detalles', [OrdenController::class, 'guardardetalle']);
    Route::get('/pedido-todos', [OrdenController::class, 'listapedido']);
    Route::get('/venta-todos', [OrdenController::class, 'listaventa']);
    Route::get('/obtener', [OrdenController::class, 'show']);
    Route::post('/eliminar', [OrdenController::class, 'destroy']);
});

Route::group(['prefix' => 'deuda', 'middleware' => 'auth'], function () {
    Route::get('/create', [OrdenController::class, 'create_deuda']);
});

Route::group(['prefix' => 'pagos', 'middleware' => 'auth'], function () {
    Route::get('/pedido', [PagoController::class, 'pedido']);
    Route::get('/venta', [PagoController::class, 'venta']);   
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', [HomeController::class, 'index'])->middleware('auth');