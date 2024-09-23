<?php

namespace App\Http\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserDepositAction extends Action
{
    public function handle(int $id, float $amount): User
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($user, $amount) {
            $user->balance += $amount;
            $user->save();
        });

        return $user;
    }
}
