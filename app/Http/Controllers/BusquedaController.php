<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Busqueda;

class BusquedaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try{
            $busqueda = Busqueda::take(10)->get();

            return response()->json([
                'data' => $busqueda
            ], 200);
        }catch( \Exception $e){
            return response()->json([
                'message' => 'Ha ocurrido un error. ' .$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try{
            $rules = array(
                'texto' => 'required',
            );

            $messages = array(
                'required' => ':attribute es requerido',
            );

            $attributes = array(
                'texto' => 'Texto',
            );

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if( !$validator->fails() ){
                $busqueda        = new Busqueda;
                $busqueda->texto = $request->texto;
                $busqueda->save();

                return response()->json([
                    'message' => 'Guardado correctamente',
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Ha ocurrido un error. ' . $validator->errors()->first(),
                ], 500);
            }
        }catch( \Exception $e){
            return response()->json([
                'message' => 'Ha ocurrido un error. ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response

     */
    public function destroy($id){
        try{
            $busqueda = Busqueda::destroy($id);

            return response()->json([
                'message' => 'Eliminado correctamente',
            ], 200);


            // $busqueda->texto = $request->texto;
            // $busqueda->save();

            // $producto = Producto::where('id', $idp)
            //     ->where('comercioId', $comercioId)
            //     ->first();

            // return response()->json([
            //     'message' => 'Guardado correctamente',
            // ], 200);
        }catch( \Exception $e){
            return response()->json([
                'message' => 'Ha ocurrido un error. ' . $e->getMessage(),
            ], 500);
        }
    }
}
