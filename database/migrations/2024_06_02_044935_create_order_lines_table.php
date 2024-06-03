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
        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('order_id')
            ->constrained(
                table: 'orders',
                indexName: 'lineOrderId'
            )->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('item_id')
            ->constrained(
                table: 'items',
                indexName: 'lineItemId'
            )->onUpdate('cascade')
            ->onDelete('cascade');

            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
