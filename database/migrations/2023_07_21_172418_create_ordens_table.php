<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha');
            $table->foreignId('entidad_id')->constrained('entidads')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('total', 5, 2);
            $table->string('tipo');//pedido o venta
            $table->string('modopago')->default('Cuotas');//cuotas al contado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens');
    }
};
