<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

final class DepenseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'motif' => $this->motif,
            'montant' => $this->montant_format,
            'user' => $this->whenLoaded('user', fn () => [
                'email' => $this->user->email,
                'name' => $this->user->name,
            ]),
            'created_at' => $this->created_at,

            'can' => [
                'update' => Gate::allows('update', $this->resource),
                'delete' => Gate::allows('delete', $this->resource),
            ],
        ];
    }
}
