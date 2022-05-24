<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public static function createTransaction(Request $request)
    {
        $transaction = Transaction::updateOrCreate(
            [
                'id' => $request->transaction_id
            ],
            [
                'gas_quantity' => $request->gas_quantity,
                'amount' =>  $request->amount,
                'type' =>  $request->type,
            ]
        );
        return response()->json(['response' => $transaction->id, 'status' => 201]);
    }
    }
}
