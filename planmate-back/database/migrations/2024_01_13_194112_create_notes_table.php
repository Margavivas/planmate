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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // clave que viene del usuario para asociar claves con savings
            $table->string('title'); // titulo
            $table->text('excerpt'); // estracto
            $table->string('importance');  // importania si es 3 aparece en el dashboard
            $table->longText('content'); // texto html de la nota
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // claves de union del id del note con id user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
