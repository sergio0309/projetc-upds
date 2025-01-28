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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->dateTime("start")->nullable();
            $table->dateTime("end")->nullable();
            $table->foreignId('client_id')->nullable()->constrained('clients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('worker_id')->nullable()->constrained('workers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
