<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function create_sale(Request $request)
    {
        $sale = Sale::updateOrCreate(
            [
                'id' => $request->sale_id
            ],
            [
                'gas_quantity' => $request->gas_quantity,
                'amount' =>  $request->amount,
                'customer_id' =>  $request->customer_id,
                'discount_code' => $request->discount_code,
                'user_id' =>  $request->user_id,
                'payment_mode_id' =>  $request->payment_mode_id,
                'payment_status_id' =>  $request->payment_status_id,
                'transaction_id' =>  TransactionController::createTransaction($request->request->add(['type'=>'sale'])),
            ]
        );
        return response()->json(['response' => $sale, 'status' => 201]);
    }

    public function delete_sale(Request $request)
    {
        $sale =  Sale::find($request->sale_id)->delete();
        return response()->json(['response' => "Sale deleted successfully", 'status' => 200]);
    }


    public function read_sale(Request $request)
    {
        $sale =  Sale::find($request->sale_id);
        return response()->json(['response' => $sale, 'status' => 200]);
    }

    public function read_all_sale(Request $request)
    {
        $sales =  Sale::all();
        return response()->json(['response' => $sales, 'status' => 200]);
    } 
}
