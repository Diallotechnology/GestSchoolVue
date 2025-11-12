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
            'userable_id' => ['required', 'integer'],
            'sexe' => ['required', 'string'],
            'role' => ['required', new Enum(RoleEnum::class)],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Email déjà utilisé',
            'userable_id.required' => 'Sélectionner un utilisateur',
            'role.required' => 'Sélectionner un rôle',
            'sexe.required' => 'Sélectionner un sexe',
            'email.required' => 'Email obligatoire',
            'email.email' => 'Email invalide',
            'email.max' => 'Email trop long',
            'userable_id.integer' => 'Sélectionner un utilisateur',
            'role.enum' => 'Sélectionner un rôle',
            'sexe.string' => 'Sélectionner un sexe',
            'email.string' => 'Email invalide',
            'email.max' => 'Email trop long',
            'userable_id.integer' => 'Sélectionner un utilisateur',
            'role.enum' => 'Sélectionner un rôle',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return flash('la validation a echoué verifiez vos informations!', 'error');
    }
}
