<?php

namespace App\Http\Actions;

use App\Events\TransferCreatedEvent;
use App\Exceptions\InsufficientBalanceException;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransferStoreAction extends Action
{
    public function handle(int $sender_id, int $receiver_id, float $amount): Transfer
    {
        $sender = User::findOrFail($sender_id);
        $receiver = User::findOrFail($receiver_id);

        if ($sender->balance < $amount) {
            throw new InsufficientBalanceException();
        }

        $transfer = DB::transaction(function () use ($sender, $receiver, $amount): Transfer {
            $sender->balance -= $amount;
            $receiver->balance += $amount;
            $sender->save();
            $receiver->save();

            return Transfer::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
            ])->load(['sender', 'receiver']);
        });

        event(new TransferCreatedEvent($transfer));

        return $transfer;
    }
}
