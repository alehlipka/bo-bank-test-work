<?php

namespace App\Actions;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;

class UserUpdateAction extends Action
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function handle(int $id, array $requestData): User
    {
        return $this->userService->updateById($id, $requestData);
    }
}
