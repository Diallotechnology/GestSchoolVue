<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Teacher */
final class TeacherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'contact' => $this->contact,
            'matieres' => $this->whenLoaded('matieres', fn() => $this->matieres->pluck('nom')->toArray()),
            'classes' => $this->whenLoaded('classes', fn() => $this->classes->pluck('nom')->toArray()),
            'created_at' => $this->forDateFormat(),
        ];
    }
}
