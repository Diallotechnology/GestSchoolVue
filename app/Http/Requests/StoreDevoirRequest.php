<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Devoir;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

final class StoreDevoirRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Devoir::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'string|required',
            'delai' => 'required|date',
            'type' => ['required', 'string', Rule::in(['Devoir', 'Examen'])],
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'cours_id' => 'required|exists:cours,id',
            'teacher_id' => 'required|exists:teachers,id',
            'periode_id' => 'required|exists:periodes,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'teacher_id' => Auth::user()->userable_id,
        ]);
    }
}
