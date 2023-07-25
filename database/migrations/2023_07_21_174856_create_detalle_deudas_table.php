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
        Schema::create('detalle_deudas', function (Blueprint $table) {//cuotas
            $table->id();
            $table->integer('orden');
            $table->foreignId('orden_id')->constrained('ordens')->onDelete('cascade')->onUpdate('cascade');
            $table->string('estado')->default('Pendiente');
            $table->date('fecha');
            $table->decimal('monto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_deudas');
    }
};
