<?php

namespace App\Http\Controllers;

use App\Models\DetalleDeuda;
use App\Models\Orden;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function pedido()
    {
        $data['title'] = 'Pedido';
        $data['tipo'] = 'pedido';
        $data['ordenes'] = Orden::where('tipo', 'Proveedor')->get();
        return view('paginas.pagos.inicio', $data);
    }
    public function venta(){
        $data['title'] = 'Venta';
        $data['tipo'] = 'venta';
        $data['ordenes'] = Orden::where('tipo', 'Distribuidor')->get();
        return view('paginas.pagos.inicio', $data);
    } 
    public function store(Request $request){
        $request->validate([
            'orden_id'           => 'required',
            'monto'              => 'required|numeric|min:1',
            'responsable'        => 'required',
        ], [
            'required'   => 'El campo es obligatorio.'
        ]);
        $orden = Pago::create([
            'orden_id'          => $request->orden_id,
            'monto'             => $request->monto,
            'fechahora'         => $request->fechahora,
            'responsable'       => $request->responsable,                   
            'usuario_id'        => Auth::user()->id,
            'nrocuota'          => $request->nrocuotas,
        ]);
        $this->actualizarpagos($request->orden_id);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Satisfactorio'
        ],201);
    }
    public function lista(Request $request){
        $data['pagos'] = Pago::with('usuario')->where('orden_id', $request->id)->get();
        return $data;
    }
    public function actualizarpagos($orden_id){
        $totalpagado = Pago::where('orden_id', $orden_id)->sum('monto');
        $detallesdeudas = DetalleDeuda::where('orden_id', $orden_id)->get();
        foreach($detallesdeudas as $row){
            if($totalpagado>=$row->monto && $totalpagado>0){
                $detalleDeuda = DetalleDeuda::find($row->id);
                $detalleDeuda->estado='Pagado';
                $detalleDeuda->save();
                $totalpagado-=$row->monto;
            }
        }
    }
}
