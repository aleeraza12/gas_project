<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\User;
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
                'type' =>  $request->type,
                'company_id' =>  $request->user_id, //company id
                'outer_id' =>  $request->outer_id, //Sale|purchase id
            ]
        );
        return response()->json(['response' => $transaction->id, 'status' => 201]);
    }

    public function readTransactions(Request $request)
    {
        $transactions = Transaction::where('company_id', $request->user_id)->where('status', 'verified')->get();
        foreach ($transactions as $transaction) {
            if ($transaction->type == 'sale') {
                $data = Sale::find($transaction->outer_id);
                $transaction['customer_name'] = Customer::find($data->customer_id)->name;
                $transaction['gas_quantity'] = $data->gas_quantity;
                $transaction['payment_mode'] = $data->payment_mode;
                $transaction['updated_by'] = User::find($data->user_id)->name; //updated_by
            } else if ($transaction->type == 'purchase') {
                $data = Purchase::find($transaction->outer_id);
                $transaction['customer_name'] = $data->company_name; //company_name
                $transaction['gas_quantity'] = $data->gas_quantity;
                $transaction['updated_by'] = User::find($data->user_id)->name; //updated_by
            }
        }
        return response()->json(['response' => $transactions, 'status' => 200]);
    }

    public function read(Request $request)
    {
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
            if ($transaction->type == 'sale') {
                $data = Sale::find($transaction->outer_id);
                $transaction['customer_name'] = Customer::find($data->customer_id)->name;
                $transaction['gas_quantity'] = $data->gas_quantity;
                $transaction['payment_mode'] = $data->payment_mode;
                $transaction['updated_by'] = User::find($data->user_id)->name; //updated_by
            } else if ($transaction->type == 'purchase') {
                $data = Purchase::find($transaction->outer_id);
                $transaction['customer_name'] = $data->company_name; //company_name
                $transaction['gas_quantity'] = $data->gas_quantity;
                $transaction['updated_by'] = User::find($data->user_id)->name; //updated_by
            }
        }
        return response()->json(['response' => $transactions, 'status' => 200]);
    }

    public static function updateTransaction(Request $request)
    {
        Transaction::where('outer_id', $request->outer_id)->where('type', $request->type)->update([
            'status' =>  'verified',
        ]);
    }
    public static function updateSaleTransaction(Request $request)
    {
        Transaction::where('outer_id', $request->outer_id)->where('type', $request->type)->update([
            'amount' =>  $request->amount
        ]);
    }
}
