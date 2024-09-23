<?php

namespace App\Services;

use App\Contracts\Services\TransferServiceInterface;
use App\Models\Transfer;

class TransferService implements TransferServiceInterface
{
    public function __construct(private readonly Transfer $transfer)
    {
    }

    public function create(array $data): Transfer
    {
        return $this->transfer
            ->create($data)
            ->load(['sender', 'receiver']);
    }
}
