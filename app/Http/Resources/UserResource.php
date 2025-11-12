<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'change_password' => $this->change_password,
            'etat' => $this->etat,
            'photo' => $this->photo,
            'sexe' => $this->sexe,
            'created_at' => $this->created_at,

        ];
    }
}
