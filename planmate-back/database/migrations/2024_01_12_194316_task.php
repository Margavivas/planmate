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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // clave que viene del usuario para asociar claves con savings
            $table->string('name'); //nombre del task
            $table->text('description'); //pequenq description del task
            $table->string('status'); // status del task, por default es pending
            $table->date('date')->nullable();;// fecha de la tarea (puede ser null)
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // asociacion de claves uid con clave extranjera del usuario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
