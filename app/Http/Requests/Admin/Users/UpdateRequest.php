<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->route('user')->id,

        ];
    }
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'email.unique' => 'The email has already been used.'
        ];
    }
}
