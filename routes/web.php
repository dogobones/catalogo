<?php

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

Route::get('/', 'ProductosController@index')->name('productos');

Route::get('/productos', 'ProductosController@index')->name('productos');
Route::post('/obtener_productos', 'ProductosController@obtener_productos');
Route::post('/agregar_producto', 'ProductosController@agregar_producto');
Route::post('/editar_producto', 'ProductosController@editar_producto');
Route::post('/eliminar_producto', 'ProductosController@eliminar_producto');

Route::get('/marcas', 'MarcasController@index')->name('marcas');
Route::post('/obtener_marcas', 'MarcasController@obtener_marcas');
Route::post('/agregar_marca', 'MarcasController@agregar_marca');
Route::post('/editar_marca', 'MarcasController@editar_marca');
Route::post('/eliminar_marca', 'MarcasController@eliminar_marca');
