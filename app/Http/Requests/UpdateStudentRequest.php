<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Student::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prenom' => 'string|required|max:100',
            'nom' => 'string|required|max:100',
            'contact' => 'string|required|max:13',
            'naissance' => 'required|date',
            'sexe' => 'required|string',
            'scolarite' => 'required|integer',
            'frais' => 'required|integer',
            'classe_id' => 'required|exists:classes,id',
            'tuteur_id' => 'required|exists:tuteurs,id',
            'files' => 'nullable|array',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return flash('la validation a echoué verifiez vos informations!', 'error');
    }
}
