<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class StoreScolariteRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
            'classe_id' => 'required|exists:users,id',
            'type' => 'required|in:Inscription,Scolarité',
            'mode' => 'required|in:Virement,Chèque,Espèces',
            'adresse' => 'required|string',
            'motif' => 'required|string',
            'montant' => 'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return flash('la validation a echoué verifiez vos informations!', 'error');
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['user_id' => Auth::user()->id]);
    }
}
