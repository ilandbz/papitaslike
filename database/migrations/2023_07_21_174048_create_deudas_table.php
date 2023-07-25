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
        Schema::create('deudas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordens')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha_vencimiento');
            $table->string('estado')->default('Pendiente');
            $table->foreignId('entidad_id')->constrained('entidads')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('nrocuotas')->default(1);
            $table->string('frecuencia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
