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
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->integer('sales')->nullable();
            $table->integer('discounts')->nullable();
            $table->integer('purchases')->nullable();
            $table->integer('recorded_purchases')->nullable();
            $table->integer('previous_balance')->nullable();
            $table->integer('update')->nullable();
            $table->integer('current_balance')->nullable();
            $table->integer('calculated_IVA')->nullable();
            $table->integer('real_IVA')->nullable();
            $table->integer('comp_IUE')->nullable();
            $table->integer('calculated_IT')->nullable();
            $table->integer('real_IT')->nullable();
            $table->integer('IUE')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statements');
    }
};
