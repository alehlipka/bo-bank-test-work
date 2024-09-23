<?php

namespace App\Actions;

use App\Contracts\Services\TransferServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Events\TransferCreatedEvent;
use App\Exceptions\InsufficientBalanceException;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;

class TransferStoreAction extends Action
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly TransferServiceInterface $transferService
    ) {}

    public function handle(int $senderId, int $receiverId, float $amount): Transfer
    {
        $sender = $this->userService->findById($senderId);
        $receiver = $this->userService->findById($receiverId);

        if ($sender->balance < $amount) {
            throw new InsufficientBalanceException();
        }

        $transfer = DB::transaction(function () use ($sender, $receiver, $amount): Transfer {
            $this->userService->decreaseBalance($sender, $amount);
            $this->userService->increaseBalance($receiver, $amount);

            return $this->transferService->create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
            ]);
        });

        event(new TransferCreatedEvent($transfer));

        return $transfer;
    }
}
