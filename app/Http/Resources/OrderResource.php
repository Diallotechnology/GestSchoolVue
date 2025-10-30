<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

final class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'destinataire' => $this->destinataire,
            'expediteur' => $this->expediteur,
            'montant' => $this->montant_format,
            'montant_usd' => $this->montant_usd,
            'taux_devise' => $this->taux_devise,
            'frais' => $this->frais_format,
            'credit' => $this->credit_format,
            'total' => $this->montant_total(),
            'user' => $this->whenLoaded('user', fn () => [
                'email' => $this->user->email,
                'name' => $this->user->name,
            ]),
            'devise' => $this->whenLoaded('devise', fn () => [
                'taux' => $this->devise->taux,
                'name' => $this->devise->name,
            ]),
            'client' => $this->client ? $this->whenLoaded('client', fn () => [
                'nom' => $this->client->nom,
                'prenom' => $this->client->prenom,
                'contact' => $this->client->contact,
            ]) : null,
            'created_at' => $this->created_at,
            'can' => [
                'show' => Gate::allows('view', $this->resource),
                'update' => Gate::allows('update', $this->resource),
                'delete' => Gate::allows('delete', $this->resource),
            ],
        ];
    }
}
