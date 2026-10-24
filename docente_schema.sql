CREATE TABLE IF NOT EXISTS docentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100) NOT NULL,
    aula VARCHAR(20) NOT NULL
);

INSERT INTO docentes (id, nombre, especialidad, aula) VALUES
(1, 'Ing. Juan Perez', 'Sistemas Operativos', 'Lab-3'),
(2, 'Ing. Maria Quispe', 'Bases de Datos', 'Lab-1');