<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    public function proveedor()
    {
        $data['title'] = 'Proveedores';
        $data['tipoentidad'] = 'Proveedor';
        return view('paginas.entidades.inicio', $data);
    }
    public function distribuidor()
    {
        $data['title'] = 'Distribuidores';
        $data['tipoentidad'] = 'Distribuidor';
        return view('paginas.entidades.inicio', $data);
    }
    public function listaproveedores(){
        $data['entidades'] = Entidad::where('tipo', 'Proveedor')->get();
        return $data;
    }
    public function listadistribuidores(){
        $data['entidades'] = Entidad::where('tipo', 'Distribuidor')->get();
        return $data;
    }
    public function store(Request $request)
    {
        if(!$request->id){
            $request->validate([
                'ruc_dni'           => 'required',
                'nombre'            => 'required',
                'representante'     => 'required',
                'correo'            => 'required|email',
                'telefono'          => 'required',
                'tipo'              => 'required'
            ], [
                'ruc_dni.required'          => 'El campo RUC O DNI es obligatorio.',
                'nombre.required'           => 'El campo nombre es obligatorio.',
                'representante.required'    => 'El campo representante es obligatorio.',
                'correo.required'           => 'El campo correo es obligatorio.',
                'correo.email'              => 'El campo correo debe ser un email valido.',
                'telefono.required'         => 'El campo telefono es obligatorio.',
                'tipo.required'             => 'El campo tipo es obligatorio.',
            ]);
            $entidad = Entidad::create([
                'ruc_dni'        => $request->ruc_dni,
                'nombre'         => $request->nombre,
                'representante'  => $request->representante,
                'correo'         => $request->correo,
                'telefono'       => $request->telefono,
                'direccion'       => $request->direccion,
                'tipo'           => $request->tipo,
            ]);
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Registro Satisfactorio'
            ],201);
        }else{
            $request->validate([
                'ruc_dni'           => 'required',
                'nombre'            => 'required',
                'representante'     => 'required',
                'correo'            => 'required|email',
                'telefono'          => 'required',
                'tipo'              => 'required'
            ], [
                'nombre.required'         => 'El campo nombre es obligatorio.',
                'tipo.required'           => 'El campo tipo es obligatorio.',
                'precio.required'         => 'El campo precio es obligatorio.',
                'precio.numeric'          => 'El campo precio debe ser numérico.',
                'unidad_medida.required'  => 'El campo unidad_medida es obligatorio.'
            ]);

            $entidad = Entidad::where('id', $request->id)->update([
                'ruc_dni'        => $request->ruc_dni,
                'nombre'         => $request->nombre,
                'representante'  => $request->representante,
                'correo'         => $request->correo,
                'telefono'       => $request->telefono,
                'direccion'       => $request->direccion,
                'tipo'           => $request->tipo
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
        $entidad = Entidad::where('id',$request->id)->first();
        return response()->json($entidad, 200);
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
        $entidad = Entidad::where('id',$request->id)->first();
        $entidad->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Eliminado'
        ]);
    }
}
