<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(TransactionRequest $request)
    {
        $user = auth()->user();
        $type = $request->type;
        $amount = $request->amount;

        // Calculate the new balance
        $newBalance = $type === 'deposit' ? $user->balance + $amount : $user->balance - $amount;

        // Prevent balance from going negative
        if ($newBalance < 0) {
            return response()->json(['error' => 'Insufficient balance'], 422);
        }

        // Update user's balance
        $user->balance = $newBalance;
        $user->save();

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'amount' => $amount,
            'balance_after' => $newBalance,
        ]);

        return response()->json(['transaction' => $transaction], 201);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $transactions = $user->transactions()->orderBy('created_at', 'desc')->get();

        return response()->json(['transactions' => $transactions]);
    }
}
