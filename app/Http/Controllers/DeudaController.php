<?php

namespace App\Http\Controllers;

use App\Models\DetalleDeuda;
use App\Models\DetalleOrden;
use App\Models\Deuda;
use App\Models\Orden;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeudaController extends Controller
{
    public function show(Request $request){
        $orden = Orden::with(['usuario:id,name', 'entidad:id,nombre', 'detallesdeuda', 'detallespagos'])->where('id', $request->id)->first();
        $deuda = Deuda::where('orden_id', $request->id)->first();
        $data['title'] = $orden->tipo;
        $data['orden'] = $orden;
        $data['deuda'] = $deuda;
        return view('paginas.deuda.inicio', $data);
    }
    public function store(Request $request){
        $request->validate([
            'orden_id' => 'required',
            'fecha_vencimiento' => 'required',
            'entidad_id' => 'required',
            'nrocuotas' => 'required|numeric|min:1',
            'frecuencia' => 'required'
        ], [
            'required'   => 'El campo es obligatorio.',
            'nrocuotas.min' => 'nro de cuotas es minimo 1'
        ]);
        $deuda = Deuda::create([
            'orden_id'          => $request->orden_id,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'estado'            => 'DEBE',
            'entidad_id'        => $request->entidad_id,
            'nrocuotas'         => $request->nrocuotas,
            'frecuencia'        => $request->frecuencia,
        ]);
        $fechaInicial = date('Y-m-d');
        $numeroCuotas = $request->nrocuotas;
        $frecuenciaPago = $request->frecuencia;
        $fechasVencimiento = [];
        $cuota = $request->total/$request->nrocuotas;
        $fechaActual = Carbon::createFromFormat('Y-m-d', $fechaInicial);
        $indice=1;
        for ($i = 0; $i < $numeroCuotas; $i++) {
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
                default:
                    break;
            }
            $fecha = $fechaActual->format('Y-m-d');
            $detalledeuda = DetalleDeuda::create([
                'orden'     => $indice,
                'orden_id' => $request->orden_id,
                'estado' => 'DEBE',
                'fecha' => $fecha,
                'monto' => $cuota
            ]);
            $indice++;
        }
        return response()->json([
            'ok' => 1,
            'deuda_id' => 1,
            'mensaje' => 'Generacion Satisfactoria'
        ],201);
    }
    public function lista_vencidos(){
        $fechaActual = Carbon::now()->toDateString();
        $data['registros'] = DetalleDeuda::with(['Orden:id,total,entidad_id', 'Orden.entidad:id,nombre'])
        ->whereDate('fecha', '<=', $fechaActual)
        ->where('estado', 'DEBE')
        ->groupBy('orden_id')->selectRaw('MIN(id) as id, orden_id')->get();
        return $data;
    }
}
