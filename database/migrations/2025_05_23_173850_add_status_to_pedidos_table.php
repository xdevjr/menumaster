<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->enum('status', ['carrinho', 'finalizado'])->default('carrinho')->after('qtd');
            $table->string('numero_pedido')->nullable()->after('status');
            $table->timestamp('finalizado_em')->nullable()->after('numero_pedido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['status', 'numero_pedido', 'finalizado_em']);
        });
    }
};
