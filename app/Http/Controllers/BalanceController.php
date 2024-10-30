<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function show(Request $request)
    {
        $user = auth()->user();

        return response()->json(['balance' => $user->balance]);
    }
}
