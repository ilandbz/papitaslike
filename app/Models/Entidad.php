<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;
    protected $fillable=['ruc_dni', 'nombre', 'representante', 'correo', 'telefono', 'direccion', 'tipo'];
}
