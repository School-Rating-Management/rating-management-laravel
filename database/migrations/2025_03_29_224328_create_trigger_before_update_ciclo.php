<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTriggerBeforeUpdateCiclo extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER before_update_ciclo
            BEFORE UPDATE ON alumnos
            FOR EACH ROW
            BEGIN
                -- Solo ejecutar si el ciclo realmente cambia
                IF OLD.ciclo_id IS NOT NULL AND OLD.ciclo_id <> NEW.ciclo_id THEN

                    -- 1️⃣ Obtener el grado actual del alumno
                    SET @grado_actual = (SELECT grado_id FROM grupos WHERE id = OLD.grupo_id);

                    -- 2️⃣ Guardar el historial del alumno antes del cambio de ciclo
                    INSERT INTO historial_alumnos (alumno_id, ciclo_id, grado_id, grupo_id, materia_id, calificacion, created_at, updated_at)
                    SELECT
                        OLD.id,
                        OLD.ciclo_id,
                        g.grado_id,
                        OLD.grupo_id,
                        c.materia_id,
                        c.calificacion,
                        NOW(),
                        NOW()
                    FROM calificaciones c
                    LEFT JOIN grupos g ON OLD.grupo_id = g.id
                    WHERE c.alumno_id = OLD.id;

                    -- 3️⃣ Si el alumno está en 6° grado, desactivarlo
                    IF @grado_actual = 6 THEN
                        SET NEW.activo = 0; -- Desactivar alumno
                    ELSE
                        -- 4️⃣ Obtener la sección actual del alumno (A, B, C)
                        SET @seccion_actual = (SELECT SUBSTRING_INDEX(nombre_grupo, '-', -1) FROM grupos WHERE id = OLD.grupo_id);

                        -- 5️⃣ Calcular el nuevo grado (avanza al siguiente)
                        SET @nuevo_grado = @grado_actual + 1;

                        -- 6️⃣ Buscar un grupo con el mismo grado nuevo y la misma sección
                        SET @nuevo_grupo = (
                            SELECT id FROM grupos
                            WHERE grado_id = @nuevo_grado
                            AND nombre_grupo LIKE CONCAT('%-', @seccion_actual)
                            LIMIT 1
                        );

                        -- 7️⃣ Si no hay grupo disponible en el nuevo ciclo, mantener el grupo anterior
                        SET NEW.grupo_id = IFNULL(@nuevo_grupo, OLD.grupo_id);

                        -- 8️⃣ Eliminar calificaciones previas del alumno en el ciclo anterior
                        DELETE FROM calificaciones WHERE alumno_id = OLD.id;

                        -- 9️⃣ Asignar nuevas materias del grado correspondiente con calificaciones en NULL
                        INSERT INTO calificaciones (alumno_id, materia_id, calificacion)
                        SELECT NEW.id, mg.materia_id, NULL
                        FROM materias_grados mg
                        WHERE mg.grado_id = @nuevo_grado;
                    END IF;

                END IF;
            END;
        ");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_update_ciclo;");
    }
}
