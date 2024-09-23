<?php

namespace App\Http\Controllers;

use App\Actions\UserDepositAction;
use App\Actions\UserUpdateAction;
use App\Http\Requests\UserDepositRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function update(UserUpdateRequest $request, int $id): JsonResource
    {
        $user = app(UserUpdateAction::class)
            ->handle($id, $request->validated());

        return $this->respondWithSuccess(new UserResource($user));
    }

    public function deposit(UserDepositRequest $request, int $id): JsonResource
    {
        $user = app(UserDepositAction::class)
            ->handle($id, $request->input('amount'));

        return $this->respondWithSuccess(new UserResource($user));
    }
}
