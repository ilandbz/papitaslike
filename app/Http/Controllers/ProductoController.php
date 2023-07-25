<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $data['title'] = 'Productos';
        $data['unidades'] = UnidadMedida::get();
        return view('paginas.producto.inicio', $data);
    }
    public function cargarvistatabla(){
        $data['productos'] = Producto::get();
        $html = view('paginas.productos.vistatabla', $data)->render();
        return response()->json([
            'vista' => $html
        ], 200);
    }

    public function lista(){
        $data['productos'] = Producto::get();
        return $data;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!$request->id){
            $request->validate([
                'nombre'            => 'required',
                'tipo'              => 'required',
                'precio'            => 'required|numeric',
                'unidad_medida'     => 'required'
            ], [
                'nombre.required'   => 'El campo nombre es obligatorio.',
                'tipo.required' => 'El campo tipo es obligatorio.',
                'precio.required'       => 'El campo precio es obligatorio.',
                'precio.numeric'        => 'El campo precio debe ser numérico.',
                'unidad_medida.required'     => 'El campo unidad_medida es obligatorio.'
            ]);
            $producto = Producto::create([
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
            $request->validate([
                'tipo' => 'required',
                'precio' => 'required',
                'precio' => 'unidad_medida',
                'nombre'       => [
                    'required',
                    Rule::unique('productos')->ignore($request->id)
                ]
            ], [
                'nombre.required'   => 'El campo nombre es obligatorio.',
                'tipo.required' => 'El campo tipo es obligatorio.',
                'precio.required'       => 'El campo precio es obligatorio.',
                'precio.numeric'        => 'El campo precio debe ser numérico.',
                'unidad_medida.required'     => 'El campo unidad_medida es obligatorio.'
            ]);

            $persona = Producto::where('id', $request->id)->update([
                'nombre'        => $request->nombre,
                'tipo'          => $request->tipo,
                'precio'        => $request->precio,
                'unidad_medida' => $request->unidad_medida
            ]);

            return response()->json([
                'ok' => 1,
                'mensaje' => 'Actualizacion Satisfactoria'
            ],201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request){
        $producto = Producto::where('id',$request->id)->first();
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
        $docente = Producto::where('id',$request->id)->first();
        $docente->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Eliminado'
        ]);
    }

}
