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
        Schema::create('periodos', function (Blueprint $table) {
            $table->id(); 
            $table->date('periodo_inicio');
            $table->date('periodo_fim');
            $table->unsignedBigInteger('promotor_id'); 
            $table->timestamps();

            $table->foreign('promotor_id')->references('id')->on('promotores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};