-- Ejecutar después de 01_estudiantes_mysql.sql en la base del grupo.
-- Alternativa a la migración Laravel; no ejecutar ambos métodos en la misma
-- base sin registrar la migración.

CREATE TABLE IF NOT EXISTS calificaciones (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    estudiante_id BIGINT UNSIGNED NOT NULL,
    docente_id INT UNSIGNED NOT NULL,
    asignatura VARCHAR(100) NOT NULL,
    nota DECIMAL(5, 2) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    KEY calificaciones_estudiante_id_asignatura_index (estudiante_id, asignatura),
    CONSTRAINT calificaciones_estudiante_id_foreign
        FOREIGN KEY (estudiante_id) REFERENCES estudiantes (id)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
