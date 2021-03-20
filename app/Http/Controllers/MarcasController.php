<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MarcasController extends Controller
{
  public function index() {
    return view('marcas');
  }
  public function obtener_marcas(Request $request) {
    $result = DB::table('marcas')->whereNull('deleted_at')->get();
    return $result;
  }
  public function agregar_marca(Request $request) {
    $nombre = $request->nombre;
    $repetidos = DB::table('marcas')->where('nombre', $nombre)->whereNull('deleted_at')->first();
    if(empty($repetidos)) {
      DB::table('marcas')->insert([
        'nombre' => $nombre
      ]);
      return 1;
    } else {
      return 0;
    }
  }
  public function editar_marca(Request $request) {
    $marca_id = $request->marca_id;
    $nombre = $request->nombre;
    $activa = $request->activa;
    $activa = ($activa != null) ? 1 : 0;
    $repetidos = DB::table('marcas')->where('nombre', $nombre)->where('id', '<>', $marca_id)->whereNull('deleted_at')->first();
    if(empty($repetidos)) {
      DB::table('marcas')->where('id', $marca_id)->update([
        'nombre' => $nombre,
        'activa' => $activa,
        'updated_at' => Carbon::now()
      ]);
      return 1;
    } else {
      return 0;
    }
  }
  public function eliminar_marca(Request $request) {
    $marca_id = $request->marca_id;
    DB::table('marcas')->where('id', $marca_id)->update([
      'deleted_at' => Carbon::now()
    ]);
    return 1;
  }
}
