<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function pedido()
    {
        $data['title'] = 'Pedido';
        $data['tipo'] = 'pedido';
        $data['ordenes'] = Orden::where('tipo', 'Proveedor')->get();
        return view('paginas.pagos.inicio', $data);
    }
    public function venta()
    {
        $data['title'] = 'Venta';
        $data['tipo'] = 'venta';
        $data['ordenes'] = Orden::where('tipo', 'Distribuidor')->get();
        return view('paginas.pagos.inicio', $data);
    }    
}
