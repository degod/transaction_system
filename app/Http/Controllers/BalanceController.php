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
        $user = User::first();
        if(empty($user)){
            // Run the specific seeder
            Artisan::call('db:seed', [
                '--class' => 'DatabaseSeeder'
            ]);
        }
        $user = User::first();

        return response()->json(['balance' => $user->balance]);
    }
}
