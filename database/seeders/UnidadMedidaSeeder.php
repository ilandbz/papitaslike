<?php

namespace Database\Seeders;

use App\Models\UnidadMedida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => '4A','nombre' => 'BOBINAS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'BJ','nombre' => 'BALDE']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'BLL','nombre' => 'BARRILES']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'BG','nombre' => 'BOLSA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'BO','nombre' => 'BOTELLAS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'BX','nombre' => 'CAJA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'CT','nombre' => 'CARTONES']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'CMK','nombre' => 'CENTIMETRO CUADRADO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'CMQ','nombre' => 'CENTIMETRO CUBICO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'CMT','nombre' => 'CENTIMETRO LINEAL']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'CEN','nombre' => 'CIENTO DE UNIDADES']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'CY','nombre' => 'CILINDRO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'CJ','nombre' => 'CONOS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'DZN','nombre' => 'DOCENA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'DZP','nombre' => 'DOCENA POR 10**6']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'BE','nombre' => 'FARDO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'GLI','nombre' => 'GALON INGLES (4,545956L)']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'GRM','nombre' => 'GRAMO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'GRO','nombre' => 'GRUESA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'HLT','nombre' => 'HECTOLITRO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'LEF','nombre' => 'HOJA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'SET','nombre' => 'JUEGO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'KGM','nombre' => 'KILOGRAMO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'PF','nombre' => 'PALETAS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'PK','nombre' => 'PAQUETE']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'PR','nombre' => 'PAR']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'FOT','nombre' => 'PIES']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'FTK','nombre' => 'PIES CUADRADOS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'FTQ','nombre' => 'PIES CUBICOS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'C62','nombre' => 'PIEZAS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'PG','nombre' => 'PLACAS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'ST','nombre' => 'PLIEGO']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'INH','nombre' => 'PULGADAS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'RM','nombre' => 'RESMA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'DR','nombre' => 'TAMBOR']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'STN','nombre' => 'TONELADA CORTA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'LTN','nombre' => 'TONELADA LARGA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'TNE','nombre' => 'TONELADAS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'TU','nombre' => 'TUBOS']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'NIU','nombre' => 'UNIDAD (BIENES)']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'ZZ','nombre' => 'UNIDAD (SERVICIOS)']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'GLL','nombre' => 'US GALON (3,7843 L)']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'YRD','nombre' => 'YARDA']);
        $unidadmedida = UnidadMedida::firstOrCreate([ 'codigo_sunat' => 'YDK','nombre' => 'YARDA CUADRADA']);
    }
}
