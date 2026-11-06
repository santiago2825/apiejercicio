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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("apellido");
            $table->date("fecha nacimiento");
            $table->string("expediente")->unique();
            $table->string('imagen_url');
            $table->string('imagen_public_id');

            //llave foranea de modulo
            
            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')
            ->references('id')
            ->on('modules')
            ->onDelete('cascade')
            ->onUpdate('cascade')
            ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
