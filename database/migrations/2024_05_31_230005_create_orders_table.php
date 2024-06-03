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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('receiver_name');
            $table->string('receiver_address');
            $table->string('receiver_phone');
            $table->string('invoice')->nullable();
            
            $table->foreignId('user_id')
            ->constrained(
                table: 'users',
                indexName: 'orderUserId'
            )->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('payment_id')
            ->constrained(
                table: 'payment_methods',
                indexName: 'order{Payment}Id'
            )->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('privilege_id')
            ->constrained(
                table: 'privileges',
                indexName: 'orderPrivilegeId'
            )->onUpdate('cascade')
            ->onDelete('cascade');

            $table->boolean('isPaid')->default(false);
            $table->integer('price');
            $table->integer('price_after_tax');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
