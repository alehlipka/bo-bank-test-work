<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Exceptions\NotFoundException;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly User $user)
    {
    }

    public function findById(int $userId): User
    {
        $user = $this->user->newQuery()->find($userId);

        if (is_null($user)) {
            throw new NotFoundException;
        }

        return $user;
    }

    public function updateById(int $userId, array $data): User
    {
        $user = $this->findById($userId);
        return tap($user)->update($data);
    }

    public function increaseBalance(User $user, float $amount): User
    {
        $user->balance += abs($amount);
        return tap($user)->save();
    }

    public function decreaseBalance(User $user, float $amount): User
    {
        $user->balance -= abs($amount);
        return tap($user)->save();
    }
}
