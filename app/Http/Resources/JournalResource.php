<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class JournalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'created_at' => $this->created_at,
            'user_id' => $this->whenLoaded('user', fn () => [
                'email' => $this->user->email,
                'name' => $this->user->name,
            ]),
        ];
    }
}
