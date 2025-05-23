<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MoneyInsertionController extends Controller
{
    public function updateInsertedAmount(Request $request)
    {
        $amount = floatval($request->input('inserted_amount'));
        Session::put('inserted_total', $amount);

        // Log the insertion for debugging
        \Log::info('Money inserted: ₱' . number_format($amount, 2));

        return response()->json([
            'status' => 'success',
            'total' => $amount
        ]);
    }

    public function resetInsertedAmount()
    {
        Session::forget('inserted_total');
        return response()->json(['status' => 'success']);
    }
} 