<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionValidationRequest;
use App\Http\Requests\UpdateTransactionValidationRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => "success",
            'message' => 'Transactions List Retrieved Successfully',
            'data' => TransactionResource::collection(Transaction::all()),
        ], 200);
        return;
    }

    public function store(CreateTransactionValidationRequest $request)
    {
        $input = $request->validated();

        $user = User::findOrFail($input['user_id']);

        // Adjust User Balance based on transaction type

        $amount = $input['amount'];
        $user->updateUserBalance($amount, $input['type']);

        $transaction = Transaction::create($input);

        return response()->json([
            'status' => "success",
            'message' => 'Transaction created Successfully',
            'data' => new TransactionResource($transaction),
        ], 201);

    }

    public function show(Transaction $transaction)
    {
        return response()->json([
            'status' => "success",
            'message' => 'Transaction has been retrieved',
            'data' => new TransactionResource($transaction),
        ], 200);

    }

    public function update(UpdateTransactionValidationRequest $request, Transaction $transaction)
    {
        $input = $request->validated();

        $transaction->update($input);

        return response()->json([
            'status' => "success",
            'message' => 'Transaction has been updated Successfully',
            'data' => new TransactionResource($transaction),
        ], 200);

    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json([
            'status' => "success",
            'message' => 'Transaction has been deleted Successfully',

        ], 204);
    }
}
