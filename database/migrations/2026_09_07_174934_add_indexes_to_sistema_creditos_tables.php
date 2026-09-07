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
        Schema::table('clientes', function (Blueprint $table) {
            $table->index('estado');
        });

        Schema::table('creditos', function (Blueprint $table) {
            $table->index('estado');
            $table->index('fecha_vencimiento');
            $table->index(['cliente_id', 'estado']);
        });

        Schema::table('pagos', function (Blueprint $table) {
            $table->index('fecha_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropIndex(['estado']);
        });

        Schema::table('creditos', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropIndex(['fecha_vencimiento']);
            $table->dropIndex(['cliente_id', 'estado']);
        });

        Schema::table('pagos', function (Blueprint $table) {
            $table->dropIndex(['fecha_pago']);
        });
    }
};
