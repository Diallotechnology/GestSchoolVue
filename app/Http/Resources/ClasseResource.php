<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Classe */
final class ClasseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'scolarite' => $this->scolarite_format,
            'frais' => $this->frais_format,
            'filiere' => $this->whenLoaded('filiere', fn() => [
                'nom' => $this->filiere->nom,
            ]),
            'matieres' => $this->whenLoaded('matieres', fn() => $this->matieres->pluck('nom')->toArray()),
            'created_at' => $this->forDateFormat(),
        ];
    }
}
