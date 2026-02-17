<?php

namespace App\Repositories\Interfaces;

use App\Models\Negotiation;
use Illuminate\Database\Eloquent\Collection;

interface INegotiationRepository
{
    public function create(array $data): Negotiation;
    public function findByUid(string $uid): ?Negotiation;
    public function update(Negotiation $negotiation, array $data): bool;
    public function addRound(Negotiation $negotiation, array $data);
}
