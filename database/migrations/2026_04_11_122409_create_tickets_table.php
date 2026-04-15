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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('equipo');
            $table->text('averia');
            $table->text('notas_tecnicas')->nullable();
            $table->enum('estado', ['Recibido', 'En Proceso', 'Esperando Repuesto', 'Listo', 'Entregado'])->default('Recibido');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
