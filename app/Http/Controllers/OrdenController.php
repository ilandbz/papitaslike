<?php

namespace App\Http\Controllers;

use App\Models\DetalleOrden;
use App\Models\Entidad;
use App\Models\Orden;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
{
    public function pedido()
    {
        $data['title'] = 'Pedido';
        $data['productos'] = Producto::where('tipo', 'Insumo')->get();
        $data['entidades'] = Entidad::where('tipo', 'Proveedor')->get();
        return view('paginas.orden.inicio', $data);
    }
    public function venta()
    {
        $data['title'] = 'Venta';
        $data['productos'] = Producto::where('tipo', 'Producto')->get();
        $data['entidades'] = Entidad::where('tipo', 'Distribuidor')->get();
        return view('paginas.orden.inicio', $data);
    }    
    public function listapedido(){
        $data['ordenes'] = Orden::with(['usuario:id,name', 'entidad:id,ruc_dni,nombre'])->where('tipo', 'Pedido')->withCount('deuda')->get();
        return $data;
    }
    public function listaventa(){
        $data['ordenes'] = Orden::with(['usuario:id,name', 'entidad:id,ruc_dni,nombre'])->where('tipo', 'Venta')->withCount('deuda')->get();
        return $data;
    }
    public function create_deuda(Request $request){
        $data['title'] = 'Deudas';
        $data['orden'] = Orden::with(['entidad:id,nombre', 'detalles.producto','detalles'])->where('id', $request->id)->first();
        return view('paginas.deuda.create', $data);
    }


    public function calcular_fechavencimiento(Request $request){
        $fechaInicial = date('Y-m-d');
        $numeroCuotas = $request->nrocuotas;
        $frecuenciaPago = $request->frecuencia;
        $fechasVencimiento = [];

        $fechaActual = Carbon::createFromFormat('Y-m-d', $fechaInicial);

        // Calcular la fecha de vencimiento para cada cuota
        for ($i = 0; $i < $numeroCuotas; $i++) {
            // Ajustar la frecuencia de pago según la opción seleccionada
            switch ($frecuenciaPago) {
                case 'Diario':
                    $fechaActual->addDay();
                    break;
                case 'Semanal':
                    $fechaActual->addWeek();
                    break;
                case 'Mensual':
                    $fechaActual->addMonth();
                    break;
                // Puedes agregar más casos según tus necesidades
                default:
                    // Si la opción no coincide con ninguna de las anteriores, puedes manejar el caso aquí
                    break;
            }
            $fechasVencimiento = $fechaActual->format('Y-m-d');
        }
    
        $data['fecha_vencimiento']=$fechasVencimiento;
        return $data;

    }
    public function store(Request $request){
        if(!$request->id){
            $request->validate([
                'usuario_id'         => 'required',
                'fecha'              => 'required',
                'entidad_id'         => 'required|numeric',
                'total'              => 'required',
                'tipo'               => 'required',
                'modopago'           => 'required'
            ], [
                'required'   => 'El campo es obligatorio.'
            ]);
            $orden = Orden::create([
                'usuario_id'        => $request->usuario_id,
                'fecha'             => $request->fecha,
                'entidad_id'        => $request->entidad_id,
                'total'             => $request->total,
                'tipo'              => $request->tipo,
                'modopago'          => $request->modopago,
            ]);
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Registro Satisfactorio'
            ],201);
        }else{
            $request->validate([
                'usuario_id'         => 'required',
                'fecha'              => 'required',
                'entidad_id'         => 'required|numeric',
                'total'              => 'required',
                'tipo'               => 'required',
                'modopago'           => 'required'
            ], [
                'required'   => 'El campo es obligatorio.'
            ]);
            $orden = Orden::where('id', $request->id)->update([
                'usuario_id'        => $request->usuario_id,
                'fecha'             => $request->fecha,
                'entidad_id'        => $request->entidad_id,
                'total'             => $request->total,
                'tipo'              => $request->tipo,
                'modopago'          => $request->modopago
            ]);
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Actualizacion Satisfactoria'
            ],201);
        }
    }
    public function guardardetalle(Request $request){

        $detalles = $request->detalles;
        $usuario_id = Auth::user()->id;
        if(!$request->id){
            $request->validate([
                'fecha'              => 'required',
                'entidad_id'         => 'required|numeric',
                'total'              => 'required|numeric|min:1',
                'tipo'               => 'required',
                'modopago'           => 'required'
            ], [
                'required'   => 'El campo es obligatorio.',
                'total.min'  => 'El valor del total no es valido'
            ]);
            $orden = Orden::create([
                'usuario_id'   => $usuario_id,
                'fecha'        => $request->fecha,
                'entidad_id'   => $request->entidad_id,
                'total'        => $request->total,
                'tipo'         => $request->tipo,
                'modopago'     => $request->modopago
            ]);
            foreach ($detalles as $detalle) {
                DetalleOrden::create([
                    'orden_id' => $orden->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio' => $detalle['precio'],
                    'subtotal' => $detalle['subtotal'],
                ]);
            }
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Registro Satisfactorio'
            ],201);
        }else{
            $request->validate([
                'fecha'              => 'required',
                'entidad_id'         => 'required|numeric',
                'total'              => 'required|numeric|min:1',
                'tipo'               => 'required',
                'modopago'           => 'required'
            ], [
                'required'   => 'El campo es obligatorio.',
                'total.min'  => 'El valor del total no es valido'
            ]);
            $orden = Producto::where('id', $request->id)->update([
                'usuario_id'   => $usuario_id,
                'fecha'        => $request->fecha,
                'entidad_id'   => $request->entidad_id,
                'total'        => $request->total,
                'tipo'         => $request->tipo,
                'modopago'     => $request->modopago
            ]);
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Actualizacion Satisfactoria'
            ],201);
        }
    }
    public function show(Request $request){
        $orden = Orden::where('id',$request->id)->first();
        return response()->json($orden, 200);
    }
    public function update(Request $request, string $id){

    }
    public function destroy(Request $request){
        $orden = Orden::where('id',$request->id)->first();
        $orden->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Eliminado'
        ]);
    }
}
