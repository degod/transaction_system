<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TransactionController extends Controller
{
    public function store(TransactionRequest $request)
    {
        // Check if any user exists, if not, seed the database
        if (User::count() === 0) {
            Artisan::call('db:seed', [
                '--class' => 'DatabaseSeeder'
            ]);
        }

        $user = User::first();

        if (empty($user)) {
            return response()->json(['error' => 'No users found'], 404);
        }

        $type = $request->type;
        $amount = $request->amount;

        // Check if a recent transaction exists
        if (Transaction::hasRecentTransaction($user->id, $amount, $type)) {
            return response()->json(['error' => 'Transaction already exists within the last minute'], 409);
        }

        // Calculate the new balance
        $newBalance = $type === 'deposit' ? $user->balance + $amount : $user->balance - $amount;

        // Prevent balance from going negative
        if ($newBalance < 0) {
            return response()->json(['error' => 'Insufficient balance'], 422);
        }

        // Update user's balance
        $user->balance = $newBalance;
        $user->save();

        // Generate the unique transaction reference using the model method
        $trxReference = Transaction::generateUniqueTrxReference($user->id, $amount, $type);

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'amount' => $amount,
            'balance_after' => $newBalance,
            'trx_reference' => $trxReference
        ]);

        return response()->json(['transaction' => $transaction], 201);
    }
}
