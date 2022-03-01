<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestamoRequest extends FormRequest
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
        return [
            'user_id'       => 'required|exists:users,id',
            'libro_id'      => 'required|exists:libros,id',
            'estado'        => 'required|in:entregado,devuelto'
        ];
    }

    public function attributes()
    {
        return[
            'user_id'   => 'usuario',
            'libro_id'  => 'libro'
        ];
    }
}
