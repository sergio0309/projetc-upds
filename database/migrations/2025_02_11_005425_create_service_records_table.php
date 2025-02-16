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
        Schema::create('service_records', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('paid')->default(0);
            $table->tinyInteger('status_debt')->default(0)->comment('0 = Inactivo, 1 = Activo');
            $table->tinyInteger('status')->default(1)->comment('0 = deuda, 1 = Pendiente , 2 = Pagado' );
            $table->text('description')->nullable();
            $table->foreignId('type_service_id')->nullable()->constrained('type_services')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('statement_id')->nullable()->constrained('statements')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('service_records');
    }
};
