<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserFormRequest extends FormRequest
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
            'name'     => 'required|string',
            'email'    => 'required|email',
            'password' => Password::min(8)
                            ->mixedCase()
                            ->numbers()
                            ->symbols()
                            ->letters(),
            'phone'    => 'regex:/^\(\d{2}\)\s9\s\d{4}-\d{4}$/'
        ];
    }

    public function messages(): array
    {
        return [
            'password' => 'A senha deve ter pelo menos uma letra maiúscula, um número e um caractere especial.',
            'phone.regex' => 'O telefone deve estar no formato (XX) 9 XXXX-XXXX.'
        ];
    }
}
