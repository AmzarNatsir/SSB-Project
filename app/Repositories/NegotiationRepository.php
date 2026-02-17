<?php

namespace App\Repositories;

use App\Models\Negotiation;
use App\Repositories\Interfaces\INegotiationRepository;

class NegotiationRepository implements INegotiationRepository
{
    public function create(array $data): Negotiation
    {
        return Negotiation::create($data);
    }

    public function findByUid(string $uid): ?Negotiation
    {
        return Negotiation::with(['rounds', 'project', 'quotation', 'creator', 'approvals.approver'])
            ->where('uid', $uid)
            ->first();
    }

    public function update(Negotiation $negotiation, array $data): bool
    {
        return $negotiation->update($data);
    }

    public function addRound(Negotiation $negotiation, array $data)
    {
        return $negotiation->rounds()->create($data);
    }
}
