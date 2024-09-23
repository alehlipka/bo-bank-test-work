<?php

namespace App\Contracts\Services;

use App\Models\Transfer;

interface TransferServiceInterface
{
    public function create(array $data): Transfer;
}
