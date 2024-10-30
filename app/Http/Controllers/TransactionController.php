<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(TransactionRequest $request)
    {
        $user = User::first();
        if(empty($user)){
            // Run the specific seeder
            Artisan::call('db:seed', [
                '--class' => 'DatabaseSeeder'
            ]);
        }
        $user = User::first();

        $type   = $request->type;
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
            'user_id'       => $user->id,
            'type'          => $type,
            'amount'        => $amount,
            'balance_after' => $newBalance,
        ]);

        return response()->json(['transaction' => $transaction], 201);
    }
}
