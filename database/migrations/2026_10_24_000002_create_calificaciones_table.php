<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('estudiante_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('docente_id');
            $table->string('asignatura', 100);
            $table->decimal('nota', 5, 2);
            $table->timestamps();
            $table->index(['estudiante_id', 'asignatura']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
