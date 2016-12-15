<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateFacebookRequest extends FormRequest
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
            'codigo' => 'required|exists:re_socios,codigo',
            'dni' => 'required|exists:re_socios,numero_doc',
            'email' => 'required',
            'name' => 'required',
            'avatar' => 'required'
        ];
    }

}