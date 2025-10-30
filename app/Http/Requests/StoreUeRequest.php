<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Ue;
use Illuminate\Foundation\Http\FormRequest;

final class StoreUeRequest extends FormRequest
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
            'nom' => 'string|required|max:100',
            'code' => ['required', 'string', 'unique:'.Ue::class],
            'credit' => 'integer|required',
            'periode_id' => 'required|exists:periodes,id',
            'filiere_id' => 'required|exists:filieres,id',
            'matiere_id' => 'required|array|exists:matieres,id',
        ];
    }
}
