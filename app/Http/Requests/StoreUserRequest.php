<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class StoreUserRequest extends FormRequest
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
            'userable_id' => ['required', 'string'],
            'sexe' => ['required', 'string'],
            'role' => ['required', new Enum(RoleEnum::class)],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return flash('la validation a echoué verifiez vos informations!', 'error');
    }
}
