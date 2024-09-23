<?php

namespace App\Actions;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;

class UserDepositAction extends Action
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function handle(int $id, float $amount): User
    {
        $user = $this->userService->findById($id);
        $this->userService->increaseBalance($user, $amount);

        return $user;
    }
}
