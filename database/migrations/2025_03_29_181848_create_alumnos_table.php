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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('curp', 18)->unique();
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('padre_id')->nullable()->constrained('padres')->onDelete('set null');
            $table->foreignId('ciclo_id')->nullable()->constrained('ciclos')->onDelete('set null');
            $table->boolean('activo')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['curp', 'grupo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
