<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Matiere */
final class MatiereResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'coeficient' => $this->coeficient,
            'duree' => $this->duree,
            'created_at' => $this->forDateFormat(),
        ];
    }
}
