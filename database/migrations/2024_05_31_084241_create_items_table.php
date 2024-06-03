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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('uom_id')->constrained(
                table: 'unit_of_materials',
                indexName: 'itemUomId'
            )->onUpdate('cascade')
            ->onDelete('cascade');

            $table->string('name');
            $table->integer('sku');
            $table->integer('stock');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
