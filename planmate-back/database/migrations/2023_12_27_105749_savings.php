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
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // clave que viene del usuario para asociar claves con savings
            $table->string('name'); //nombre del saving
            $table->decimal('amount', 10, 2); // Cantidad ahorrada
            $table->decimal('goal', 10, 2); // Meta de ahorro
            $table->date('deadline')->nullable(); // Fecha límite para ahorrar
            $table->timestamps(); 

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
