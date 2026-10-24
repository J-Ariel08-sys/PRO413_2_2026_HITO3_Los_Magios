-- PRO-413 / Hito 3 / Parte 1
-- Base: MySQL DEL GRUPO. No importar en el MySQL institucional.
-- Selecciona primero una base vacía creada por el grupo.
-- Alternativa a la migración Laravel: no ejecutar ambas instalaciones en una
-- base nueva sin registrar la migración. Ver README, sección 9.
-- No incluye usuarios ni credenciales. Datos ficticios de demostración.

CREATE TABLE IF NOT EXISTS estudiantes (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    codigo VARCHAR(20) NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefono VARCHAR(20) NULL,
    fecha_nacimiento DATE NULL,
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY estudiantes_codigo_unique (codigo),
    UNIQUE KEY estudiantes_email_unique (email),
    KEY estudiantes_apellidos_nombres_index (apellidos, nombres)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO estudiantes (codigo, nombres, apellidos, email, telefono, fecha_nacimiento, estado, created_at, updated_at)
VALUES
('EST-001', 'Ana', 'Quispe', 'ana@example.com', '70000001', '2004-03-14', 'activo', NOW(), NOW()),
('EST-002', 'Luis', 'Mamani', 'luis@example.com', '70000002', '2003-11-06', 'activo', NOW(), NOW()),
('EST-003', 'Carla', 'Flores', 'carla@example.com', NULL, '2004-08-22', 'inactivo', NOW(), NOW())
ON DUPLICATE KEY UPDATE id = id;
