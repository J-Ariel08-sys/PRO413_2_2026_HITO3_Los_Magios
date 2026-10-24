<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $connection = 'mysql_institucional';

    protected $table = 'docentes';

    protected $fillable = ['nombre', 'especialidad', 'aula'];

    public $timestamps = false;
}
