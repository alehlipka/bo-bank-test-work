<?php

namespace App\Http\Controllers;
use App\Actions\TransferStoreAction;
use App\Http\Requests\TransferStoreRequest;
use App\Http\Resources\TransferResource;
use Illuminate\Http\JsonResponse;

class TransferController extends Controller
{
    public function store(TransferStoreRequest $request): JsonResponse
    {
        $transfer = app(TransferStoreAction::class)
            ->handle($request->sender_id, $request->receiver_id, $request->amount);

        return $this->respondWithSuccessCreate(new TransferResource($transfer));
    }
}
