<?php

namespace App\Contracts\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function findById(int $userId): User;
    public function updateById(int $userId, array $data): User;
    public function increaseBalance(User $user, float $amount): User;
    public function decreaseBalance(User $user, float $amount): User;
}
