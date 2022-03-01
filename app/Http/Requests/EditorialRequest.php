<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditorialRequest extends FormRequest
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
        $validacion = [];

        switch ($this->method()) {
            case 'POST':
                $validacion['nombre'] = 'required|unique:editoriales,nombre';
                break;

            case 'PUT':
                $validacion['nombre'] = 'required|'.Rule::unique('editoriales')->ignore($this->id);
                break;
        }

        return $validacion;
    }
}
