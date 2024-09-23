<?php

namespace App\Http\Controllers;
use App\Exceptions\InsufficientBalanceException;
use App\Http\Actions\TransferStoreAction;
use App\Http\Requests\TransferStoreRequest;
use App\Http\Resources\TransferResource;
use Illuminate\Http\JsonResponse;

class TransferController extends Controller
{
    public function store(TransferStoreRequest $request): JsonResponse
    {
        try {
            $transfer = app(TransferStoreAction::class)
                ->handle($request->sender_id, $request->receiver_id, $request->amount);
        } catch (InsufficientBalanceException $e) {
            return $this->errorWrongArgs('Insufficient balance', ['sender' => 'Insufficient balance']);
        }

        return $this->respondWithSuccessCreate(new TransferResource($transfer));
    }
}
