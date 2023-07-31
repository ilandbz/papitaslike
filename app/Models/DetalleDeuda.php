<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleDeuda extends Model
{
    use HasFactory;
    protected $fillable=['orden','orden_id', 'estado', 'fecha', 'monto'];
    public function Orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }
}
