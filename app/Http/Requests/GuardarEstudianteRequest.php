<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Estudiante;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarEstudianteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Demostración académica en una LAN de confianza; no incluye autenticación.
        return true;
    }

    protected function prepareForValidation(): void
    {
        $datos = [];
        foreach (['codigo', 'nombres', 'apellidos', 'email', 'telefono'] as $campo) {
            $valor = $this->input($campo);
            if (is_string($valor)) {
                $datos[$campo] = trim($valor);
            }
        }
        if (isset($datos['codigo'])) {
            $datos['codigo'] = mb_strtoupper($datos['codigo'], 'UTF-8');
        }
        if (isset($datos['email'])) {
            $datos['email'] = mb_strtolower($datos['email'], 'UTF-8');
        }
        $this->merge($datos);
    }

    public function rules(): array
    {
        $estudiante = $this->route('estudiante');
        $id = $estudiante instanceof Estudiante ? $estudiante->getKey() : null;
        return [
            'codigo' => ['bail', 'required', 'string', 'max:20', 'regex:/^[A-Z0-9-]+$/', Rule::unique('estudiantes', 'codigo')->ignore($id)],
            'nombres' => ['bail', 'required', 'string', 'max:100'],
            'apellidos' => ['bail', 'required', 'string', 'max:100'],
            'email' => ['bail', 'required', 'string', 'email:rfc', 'max:150', Rule::unique('estudiantes', 'email')->ignore($id)],
            'telefono' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+() .-]{6,20}$/'],
            'fecha_nacimiento' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:1900-01-01', 'before_or_equal:today'],
            'estado' => ['required', Rule::in(['activo', 'inactivo'])],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max.string' => 'El campo :attribute admite hasta :max caracteres.',
            'codigo.regex' => 'Usa letras sin tildes, números o guiones en el código.',
            'codigo.unique' => 'Ya existe un estudiante con ese código.',
            'email.unique' => 'Ese correo ya está registrado.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'telefono.regex' => 'Escribe un teléfono válido de 6 a 20 caracteres.',
            'fecha_nacimiento.date_format' => 'La fecha debe tener formato año-mes-día.',
            'fecha_nacimiento.after_or_equal' => 'La fecha debe ser desde el 1 de enero de 1900.',
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser futura.',
            'estado.in' => 'Selecciona activo o inactivo.',
        ];
    }

    public function attributes(): array
    {
        return ['codigo' => 'código', 'email' => 'correo', 'telefono' => 'teléfono', 'fecha_nacimiento' => 'fecha de nacimiento'];
    }
}
