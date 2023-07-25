<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::firstOrcreate([
            'nombre'       => 'Papas',
            'tipo'         => 'Insumo',
            'precio'       => 0.30,
            'unidad_medida'=> 'Saco'
        ]);
        Producto::firstOrcreate([
            'nombre'       => 'Sal',
            'tipo'         => 'Insumo',
            'precio'       => 3.00,
            'unidad_medida'=> 'Caja'
        ]);
        Producto::firstOrcreate([
            'nombre'       => 'Saborizante',
            'tipo'         => 'Insumo',
            'precio'       => 5.00,
            'unidad_medida'=> 'Caja'
        ]); 
        Producto::firstOrcreate([
            'nombre'       => 'Papitas Saladas',
            'tipo'         => 'Producto',
            'precio'       => 30,
            'unidad_medida'=> 'Caja'
        ]); 
        Producto::firstOrcreate([
            'nombre'       => 'Papitas Picantes',
            'tipo'         => 'Producto',
            'precio'       => 30,
            'unidad_medida'=> 'Caja'
        ]);                     
    }
}
