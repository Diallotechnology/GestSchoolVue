<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Cours;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class StoreCoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Cours::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'string|required|max:200',
            'files' => 'nullable',
            'description' => 'string|required',
            'matiere_id' => 'required|exists:matieres,id',
            'teacher_id' => 'required|exists:teachers,id',
            'type_id' => 'required|exists:types,id',
            'classe_id' => 'required|array|exists:classes,id',
            'periode_id' => 'required|array|exists:periodes,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $teacherId = Auth::user()->isTeacher() ? Auth::user()->userable_id : Auth::user()->id;
        $this->merge([
            // 'user_id' => Auth::user()->id,
            'teacher_id' => Auth::user()->userable_id,
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        return flash('la validation a echoué verifiez vos informations!', 'error');
    }
}
