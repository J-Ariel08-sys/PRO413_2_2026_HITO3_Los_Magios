## 3. Integrantes y Responsabilidades

| Integrante | Rol o responsabilidades | Usuario de GitHub |
| :--- | :--- | :--- |
| Integrante 1 | Configuración Docker, docker-compose y despliegue | @usuario1 |
| Integrante 2 | BD Docker, Migraciones y Modelos Laravel | @usuario2 |
| Integrante 3 | BD Institucional y variables de entorno | @usuario3 |
| Tu Nombre Completo | Lógica Cruzada (POO), Vistas y Documentación | @tu_usuario |

## Justificación de la Estructura de Datos
Para no realizar un `JOIN` directo en SQL entre dos bases de datos MySQL independientes, se utilizó la estructura de datos **`Illuminate\Support\Collection`** en memoria PHP. A través del método `keyBy('id')`, se indexan los modelos de ambas bases para acceder a los registros en tiempo constante $O(1)$ y cruzarlos mediante `.map()` antes de enviarlos a la vista Blade.

## Bases de datos

El reporte consolidado requiere la tabla `calificaciones` en la base del grupo y
la tabla `docentes` en la base institucional. Para crear las tablas del grupo,
ejecuta `php artisan migrate` o, como alternativa, ejecuta
`database/sql/01_estudiantes_mysql.sql` y después
`database/sql/02_calificaciones_mysql.sql`. Configura las credenciales
institucionales en las variables `DB_DOCENTE_*` del archivo `.env`.

## Comandos de Despliegue

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```