<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    public function pedido()
    {
        $data['title'] = 'Pedido';
        return view('paginas.orden.inicio', $data);
    }
    public function venta()
    {
        $data['title'] = 'Venta';
        return view('paginas.orden.inicio', $data);
    }    
    public function listapedido(){
        $data['ordenes'] = Orden::where('tipo', 'Pedido')->get();
        return $data;
    }
    public function listaventa(){
        $data['ordenes'] = Orden::where('tipo', 'Venta')->get();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        if(!$request->id){
            $request->validate([
                'usuario_id'            => 'required',
                'fecha'              => 'required',
                'entidad_id'            => 'required|numeric',
                'total'     => 'required',
                'tipo'      =>  'required',
                'modopago'  => 'required'
            ], [
                'nombre.required'   => 'El campo nombre es obligatorio.',
                'tipo.required' => 'El campo tipo es obligatorio.',
                'precio.required'       => 'El campo precio es obligatorio.',
                'precio.numeric'        => 'El campo precio debe ser numérico.',
                'unidad_medida.required'     => 'El campo unidad_medida es obligatorio.'
            ]);
            $producto = Orden::create([
                'nombre'        => $request->nombre,
                'tipo'          => $request->tipo,
                'precio'        => $request->precio,
                'unidad_medida' => $request->unidad_medida
            ]);
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Registro Satisfactorio'
            ],201);
        }else{

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request){
        $producto = Orden::where('id',$request->id)->first();
        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $docente = Orden::where('id',$request->id)->first();
        $docente->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Eliminado'
        ]);
    }
}
