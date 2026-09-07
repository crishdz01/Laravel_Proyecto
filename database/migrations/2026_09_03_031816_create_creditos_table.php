<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->restrictOnDelete();

            $table->date('fecha_otorgamiento');

            $table->decimal('monto', 10, 2);

            $table->decimal('tasa_interes', 5, 2);

            $table->integer('plazo');

            $table->decimal('total_credito', 10, 2);

            $table->decimal('saldo', 10, 2);

            $table->date('fecha_vencimiento');

            $table->enum('estado', [
                'activo',
                'pagado',
                'vencido'
            ])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creditos');
    }
};