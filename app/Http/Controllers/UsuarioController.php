<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Usuarios';
        return view('paginas.usuarios.inicio', $data);
    }


    public function lista(){
        $data['usuarios'] = User::get();
        return $data;
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $password = Hash::make($request->password);
        if(!$request->id){
            $request->validate([
                'name'      => 'required|unique:users,name',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required',
                'password_confirmation' => 'required|same:password'
            ], [
                'required'   => 'El campo es obligatorio.',
                'name.unique'       => 'El Nombre de Usuario ya está en uso.',
                'email.required'     => 'El campo email es obligatorio.',
                'email.email'        => 'El campo email debe ser una dirección de correo válida.',
                'email.unique'       => 'El email ya está en uso.',
                'password.required'         => 'El campo contraseña es obligatorio.',
                'password_confirmation.required' => 'El campo confirmar contraseña es obligatorio.',
                'password_confirmation.same' => 'La confirmación de contraseña no coincide con la contraseña.'
            ]);
            $usuario = User::create([ 
                'name'             => $request->name,
                'email'             => $request->email,
                'password'          => $password
            ]);
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Usuario Registrado satisfactoriamente'
            ],201);
        }else{
            $usuario = User::where('id', $request->id)->first();
            $request->validate([
                'name'     => [
                    'required',
                    Rule::unique('users')->ignore($request->id)
                ],
                'email'     => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($request->id)
                ]
            ], [
                'required'   => 'El campo es obligatorio.',
                'name.unique'       => 'El Nombre de Usuario ya está en uso.',
                'email.required'     => 'El campo email es obligatorio.',
                'email.email'        => 'El campo email debe ser una dirección de correo válida.',
                'email.unique'       => 'El email ya está en uso.',
                'password.required'         => 'El campo contraseña es obligatorio.',
                'password_confirmation.required' => 'El campo confirmar contraseña es obligatorio.',
                'password_confirmation.same' => 'La confirmación de contraseña no coincide con la contraseña.'
            ]);

            $usuario = User::where('id', $request->id)->update([ 
                'name'             => $request->name,
                'email'             => $request->email,
                'password'          => $password
            ]);
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Usuario Actualizado satisfactoriamente'
            ],201);
        }
    }
    public function resetearusuario(Request $request){
        $user = User::where('id', $request->id)->first();
        $user->password = Hash::make($user->name);
        $user->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Clave Reseteado con Exito (su dni)'
        ],200);
    }
    public function obtenerusuario(Request $request){
        $usuario = User::where('id',$request->id)->first();
        return response()->json($usuario, 200);
    }
    public function cambiarestado(Request $request){
        $usuario = User::where('id', $request->id)->first();

        $usuario->es_activo = ($usuario->es_activo == 1) ? 0 : 1;
        
        $usuario->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cambiado de Estado'
        ],200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $usuario = User::where('id',$request->id)->first();
        $usuario->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro de Usuario Eliminado'
        ]);
    }
}
