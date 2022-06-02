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
                'amount' =>  $request->amount,
                'amount' =>  $request->amount,
                'type' =>  $request->type,
                'company_id' =>  $request->user_id, //company id
                'outer_id' =>  $request->outer_id, //company id
            ]
        );
        return response()->json(['response' => $transaction->id, 'status' => 201]);
    }

    public static function updateTransaction(Request $request){
        Transaction::where('transaction_id',$request->transaction_id)->update([
            'amount' =>  $request->amount,
            'status' =>  $request->status,
        ]);
    }
}
