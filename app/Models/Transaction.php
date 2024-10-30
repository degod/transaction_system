<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'trx_reference', 'type', 'amount', 'balance_after'];

    protected static function booted()
    {
        static::creating(function ($transaction) {
            $transaction->trx_reference = self::generateUniqueTrxReference($transaction->user_id, $transaction->amount, $transaction->type);
        });
    }

    /**
     * Generate a unique transaction reference.
     */
    public static function generateUniqueTrxReference($userId, $amount, $type): string
    {
        return (string) Str::uuid(); // Generate a UUID as the transaction reference
    }

    /**
     * Check if a recent transaction exists.
     */
    public static function hasRecentTransaction($userId, $amount, $type): bool
    {
        $oneMinuteAgo = Carbon::now()->subMinute();

        return self::where('user_id', $userId)
            ->where('amount', $amount)
            ->where('type', $type)
            ->where('created_at', '>=', $oneMinuteAgo)
            ->exists();
    }
}
