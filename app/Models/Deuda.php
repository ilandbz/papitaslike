<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deuda extends Model
{
    use HasFactory;
    protected $fillable=['orden_id', 'fecha_vencimiento', 'estado', 'entidad_id', 'nrocuotas', 'frecuencia'];
    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

}
