<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LibroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validacion = [
            'autor'              => 'required|string',
            'cantidad'           => 'required|numeric',
            'fecha_publicacion'  => 'required|date',
        ];

        switch ($this->method()) {
            case 'POST':
                $validacion['nombre'] = 'required|unique:libros,nombre';
                $validacion['isbn']   = 'required|unique:libros,isbn';
                break;

            case 'PUT':
                $validacion['nombre'] = 'required|'.Rule::unique('libros')->ignore($this->id);
                $validacion['isbn']   = 'required|'.Rule::unique('libros')->ignore($this->id);
                break;
        }

        return $validacion;
    }
}
