<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            ALTER TABLE creditos
            ADD CONSTRAINT chk_creditos_monto
            CHECK (monto > 0)
        ");

        DB::statement("
            ALTER TABLE creditos
            ADD CONSTRAINT chk_creditos_tasa
            CHECK (tasa_interes >= 0)
        ");

        DB::statement("
            ALTER TABLE creditos
            ADD CONSTRAINT chk_creditos_plazo
            CHECK (plazo > 0)
        ");

        DB::statement("
            ALTER TABLE creditos
            ADD CONSTRAINT chk_creditos_total
            CHECK (total_credito > 0)
        ");

        DB::statement("
            ALTER TABLE creditos
            ADD CONSTRAINT chk_creditos_saldo
            CHECK (saldo >= 0)
        ");
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            ALTER TABLE creditos
            DROP CONSTRAINT chk_creditos_monto
        ");

        DB::statement("
            ALTER TABLE creditos
            DROP CONSTRAINT chk_creditos_tasa
        ");

        DB::statement("
            ALTER TABLE creditos
            DROP CONSTRAINT chk_creditos_plazo
        ");

        DB::statement("
            ALTER TABLE creditos
            DROP CONSTRAINT chk_creditos_total
        ");

        DB::statement("
            ALTER TABLE creditos
            DROP CONSTRAINT chk_creditos_saldo
        ");
    }
};