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
            'dni' => 'required|exists:re_socios,numero_doc',
            'email' => 'required|email|unique:re_socios,email',
            'name' => 'required',
            'avatar' => 'required'
        ];
    }


    public function response(array $errors)
    {
        return response()->json(['errors' => $errors]);
    }

}