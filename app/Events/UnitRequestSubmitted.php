<?php

namespace App\Events;

use App\Models\UnitRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnitRequestSubmitted
{
    use Dispatchable, SerializesModels;

    public UnitRequest $unitRequest;

    public function __construct(UnitRequest $unitRequest)
    {
        $this->unitRequest = $unitRequest;
    }
}
