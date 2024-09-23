<?php

namespace App\Http\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserUpdateAction extends Action
{
    public function handle(int $id, array $requestData): User
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($user, $requestData) {
            $user->update($requestData);
        });

        return $user;
    }
}
