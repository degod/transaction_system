<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function show(Request $request)
    {
        $user = auth()->user();
        return response()->json(['balance' => $user->balance]);
    }
}
