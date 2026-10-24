<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $connection = 'mysql_institucional'; // Conexión secundaria (config/database.php)
    protected $table = 'docentes';
    protected $fillable = ['nombre', 'especialidad', 'aula'];
    public $timestamps = false; // Si tu tabla no tiene created_at/updated_at
}