<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class BalanceController extends Controller
{
    public function show(Request $request)
    {
        if (User::count() === 0) {
            Artisan::call('db:seed', [
                '--class' => 'DatabaseSeeder'
            ]);
        }
        $user = User::first();

        return response()->json(['balance' => $user->balance]);
    }
}
