<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    protected $fillable = ['codigo', 'nombres', 'apellidos', 'email', 'telefono', 'fecha_nacimiento', 'estado'];

    protected function casts(): array
    {
        return ['fecha_nacimiento' => 'date'];
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn (): string => trim($this->nombres.' '.$this->apellidos));
    }
}
