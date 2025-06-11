<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        echo "Creando índices...\n";

        // MEMBRESIAS
        Schema::table('membresias', function (Blueprint $table) {
            $table->index('nombre', 'idx_membresias_nombre');
            $table->index('monto', 'idx_membresias_monto');
            $table->index('duracion', 'idx_membresias_duracion');
            $table->index(['monto', 'duracion'], 'idx_membresias_monto_duracion');
            $table->index('created_at', 'idx_membresias_created');
        });
        echo "Indices de membresías creados\n";

        // ENTRENADORES
        Schema::table('entrenadores', function (Blueprint $table) {
            $table->index('especialidad', 'idx_entrenadores_especialidad');
            $table->index('nombre', 'idx_entrenadores_nombre');
            $table->index('apellido', 'idx_entrenadores_apellido');
            $table->index(['nombre', 'apellido'], 'idx_entrenadores_nombre_completo');
            $table->index(['especialidad', 'horario'], 'idx_entrenadores_esp_horario');
            $table->index('created_at', 'idx_entrenadores_created');
        });
        echo "Indices de entrenadores creados\n";

        // SOCIOS
        Schema::table('socios', function (Blueprint $table) {
            $table->index('email', 'idx_socios_email');
            $table->index('telefono', 'idx_socios_telefono');
            $table->index('membresia_id', 'idx_socios_membresia');
            $table->index('nombre', 'idx_socios_nombre');
            $table->index('apellido', 'idx_socios_apellido');
            $table->index(['nombre', 'apellido'], 'idx_socios_nombre_completo');
            $table->index(['membresia_id', 'created_at'], 'idx_socios_membresia_fecha');
            $table->index('created_at', 'idx_socios_created');
        });
        echo "Indices de socios creados\n";

        // CLASES
        Schema::table('clases', function (Blueprint $table) {
            $table->index('entrenador_id', 'idx_clases_entrenador');
            $table->index('nombre', 'idx_clases_nombre');
            $table->index('horario', 'idx_clases_horario');
            $table->index('capacidad', 'idx_clases_capacidad');
            $table->index(['entrenador_id', 'horario'], 'idx_clases_entrenador_horario');
            $table->index(['capacidad', 'created_at'], 'idx_clases_capacidad_fecha');
            $table->index('created_at', 'idx_clases_created');
        });
        echo "Indices de clases creados\n";

        // PAGOS
        Schema::table('pagos', function (Blueprint $table) {
            $table->index('socio_id', 'idx_pagos_socio');
            $table->index('membresia_id', 'idx_pagos_membresia');
            $table->index('fecha_pago', 'idx_pagos_fecha');
            $table->index('monto', 'idx_pagos_monto');
            $table->index(['socio_id', 'fecha_pago'], 'idx_pagos_socio_fecha');
            $table->index(['membresia_id', 'fecha_pago'], 'idx_pagos_membresia_fecha');
            $table->index(['fecha_pago', 'monto'], 'idx_pagos_fecha_monto');
            $table->index(['socio_id', 'membresia_id', 'fecha_pago'], 'idx_pagos_completo');
            $table->index('created_at', 'idx_pagos_created');
        });
        echo "Indices de pagos creados\n";

        // INSCRIPCIONES
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->index('socio_id', 'idx_inscripciones_socio');
            $table->index('clase_id', 'idx_inscripciones_clase');
            $table->index('fecha_inscripcion', 'idx_inscripciones_fecha');
            $table->index(['socio_id', 'clase_id'], 'idx_inscripciones_socio_clase');
            $table->index(['clase_id', 'fecha_inscripcion'], 'idx_inscripciones_clase_fecha');
            $table->index(['socio_id', 'fecha_inscripcion'], 'idx_inscripciones_socio_fecha');
            $table->index('created_at', 'idx_inscripciones_created');


        });
        echo "Indices de inscripciones creados\n";

        // EVALUACIONES
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->index('socio_id', 'idx_evaluaciones_socio');
            $table->index('clase_id', 'idx_evaluaciones_clase');
            $table->index('puntaje', 'idx_evaluaciones_puntaje');
            $table->index(['clase_id', 'puntaje'], 'idx_evaluaciones_clase_puntaje');
            $table->index(['socio_id', 'puntaje'], 'idx_evaluaciones_socio_puntaje');
            $table->index(['clase_id', 'created_at'], 'idx_evaluaciones_clase_fecha');
            $table->index(['puntaje', 'created_at'], 'idx_evaluaciones_puntaje_fecha');
            $table->index('created_at', 'idx_evaluaciones_created');
        });
        echo "Indices de evaluaciones creados\n";

        echo "Indices creados exitosamente\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        echo "Eliminando índices...\n";

        // EVALUACIONES
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->dropIndex('idx_evaluaciones_created');
            $table->dropIndex('idx_evaluaciones_puntaje_fecha');
            $table->dropIndex('idx_evaluaciones_clase_fecha');
            $table->dropIndex('idx_evaluaciones_socio_puntaje');
            $table->dropIndex('idx_evaluaciones_clase_puntaje');
            $table->dropIndex('idx_evaluaciones_puntaje');
            $table->dropIndex('idx_evaluaciones_clase');
            $table->dropIndex('idx_evaluaciones_socio');
        });
        echo "Índices de evaluaciones eliminados\n";

        // INSCRIPCIONES
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->dropUnique('idx_inscripciones_unico');
            $table->dropIndex('idx_inscripciones_created');
            $table->dropIndex('idx_inscripciones_socio_fecha');
            $table->dropIndex('idx_inscripciones_clase_fecha');
            $table->dropIndex('idx_inscripciones_socio_clase');
            $table->dropIndex('idx_inscripciones_fecha');
            $table->dropIndex('idx_inscripciones_clase');
            $table->dropIndex('idx_inscripciones_socio');
        });
        echo "Índices de inscripciones eliminados\n";

        // PAGOS
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropIndex('idx_pagos_created');
            $table->dropIndex('idx_pagos_completo');
            $table->dropIndex('idx_pagos_fecha_monto');
            $table->dropIndex('idx_pagos_membresia_fecha');
            $table->dropIndex('idx_pagos_socio_fecha');
            $table->dropIndex('idx_pagos_monto');
            $table->dropIndex('idx_pagos_fecha');
            $table->dropIndex('idx_pagos_membresia');
            $table->dropIndex('idx_pagos_socio');
        });
        echo "Índices de pagos eliminados\n";

        // CLASES
        Schema::table('clases', function (Blueprint $table) {
            $table->dropIndex('idx_clases_created');
            $table->dropIndex('idx_clases_capacidad_fecha');
            $table->dropIndex('idx_clases_entrenador_horario');
            $table->dropIndex('idx_clases_capacidad');
            $table->dropIndex('idx_clases_horario');
            $table->dropIndex('idx_clases_nombre');
            $table->dropIndex('idx_clases_entrenador');
        });
        echo "Índices de clases eliminados\n";

        // SOCIOS
        Schema::table('socios', function (Blueprint $table) {
            $table->dropIndex('idx_socios_created');
            $table->dropIndex('idx_socios_membresia_fecha');
            $table->dropIndex('idx_socios_nombre_completo');
            $table->dropIndex('idx_socios_apellido');
            $table->dropIndex('idx_socios_nombre');
            $table->dropIndex('idx_socios_membresia');
            $table->dropIndex('idx_socios_telefono');
            $table->dropIndex('idx_socios_email');
        });
        echo "Índices de socios eliminados\n";

        // ENTRENADORES
        Schema::table('entrenadores', function (Blueprint $table) {
            $table->dropIndex('idx_entrenadores_created');
            $table->dropIndex('idx_entrenadores_esp_horario');
            $table->dropIndex('idx_entrenadores_nombre_completo');
            $table->dropIndex('idx_entrenadores_apellido');
            $table->dropIndex('idx_entrenadores_nombre');
            $table->dropIndex('idx_entrenadores_especialidad');
        });
        echo "Índices de entrenadores eliminados\n";

        // MEMBRESIAS
        Schema::table('membresias', function (Blueprint $table) {
            $table->dropIndex('idx_membresias_created');
            $table->dropIndex('idx_membresias_monto_duracion');
            $table->dropIndex('idx_membresias_duracion');
            $table->dropIndex('idx_membresias_monto');
            $table->dropIndex('idx_membresias_nombre');
        });
        echo "Índices de membresías eliminados\n";

        echo "Indices eliminados exitosamente\n";

    }
};
