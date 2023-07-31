<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    use HasFactory;

    protected $fillable=['usuario_id', 'fecha', 'entidad_id', 'total', 'tipo', 'modopago'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function entidad(): BelongsTo
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }
    public function Deuda(): HasMany
    {
        return $this->hasMany(Deuda::class);
    }
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleOrden::class);
    }    
    public function detallesdeuda(): HasMany
    {
        return $this->hasMany(DetalleDeuda::class);
    }
    public function detallespagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }    
}
