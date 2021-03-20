<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductosController extends Controller
{
  public function index() {
    $claves = DB::table('productos')->whereNull('deleted_at')->get(['clave']);
    $nombres = DB::table('productos')->whereNull('deleted_at')->distinct()->get(['nombre']);
    $marcas = DB::table('marcas')->where('activa',1)->whereNull('deleted_at')->get(['id','nombre']);
    return view('productos',compact('claves', 'nombres', 'marcas'));
  }
  public function obtener_productos(Request $request) {
    $clave = $request->clave;
    $nombre = $request->nombre;
    $marca = $request->marca;
    $clave = ($clave != '0') ? $clave : '%';
    $nombre = ($nombre != '0') ? $nombre : '%';
    $marca = ($marca != '0') ? $marca : '%';
    $result = DB::table('productos')
              ->join('marcas','marcas.id','=','productos.marca_id')
              ->select('productos.*', 'marcas.nombre AS marca')
              ->where('productos.clave', 'like', $clave)
              ->where('productos.nombre', 'like', $nombre)
              ->where('marcas.nombre', 'like', $marca)
              ->whereNull('productos.deleted_at')
              ->get();
    return $result;
  }
  public function agregar_producto(Request $request) {
    $clave = $request->clave;
    $nombre = $request->nombre;
    $marca = $request->marca;
    $repetidos = DB::table('productos')->where('clave', $clave)->whereNull('deleted_at')->first();
    if(empty($repetidos)) {
      DB::table('productos')->insert([
        'clave' => $clave,
        'nombre' => $nombre,
        'marca_id' => $marca
      ]);
      return 1;
    } else {
      return 0;
    }
  }
  public function editar_producto(Request $request) {
    $product_id = $request->product_id;
    $clave = $request->clave;
    $nombre = $request->nombre;
    $marca = $request->marca;
    $repetidos = DB::table('productos')->where('clave', $clave)->where('id', '<>', $product_id)->whereNull('deleted_at')->first();
    if(empty($repetidos)) {
      DB::table('productos')->where('id', $product_id)->update([
        'clave' => $clave,
        'nombre' => $nombre,
        'marca_id' => $marca,
        'updated_at' => Carbon::now()
      ]);
      return 1;
    } else {
      return 0;
    }
  }
  public function eliminar_producto(Request $request) {
    $product_id = $request->product_id;
    DB::table('productos')->where('id', $product_id)->update([
      'deleted_at' => Carbon::now()
    ]);
    return 1;
  }
}
