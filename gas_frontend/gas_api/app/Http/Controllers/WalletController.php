<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public static function create_wallet(Request $request)
    {
        $wallet = Wallet::updateOrCreate(
            [
                'id' => $request->wallet_id
            ],
            [
                'transaction_id' => $request->transaction_id,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'status' => $request->status,
                'authorized_by' => $request->authorized_by
            ]
        );
        return response()->json(['response' => $wallet, 'status' => 201]);
    }
    public function read(Request $request)
    {
        $wallets =  Wallet::all();
        return response()->json(['response' => $wallets, 'status' => 200]);
    }
}
