<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Transaction;
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
                'total_amount' =>  $request->total_amount,
                'price' =>  $request->price,
                'customer_id' =>  $request->customer_id,
                'customer_phone_number' =>  $request->customer_phone_number,
                'customer_type' =>  $request->customer_type,
                'discount_code' => $request->discount_code,
                'company_id' =>  $request->user_id,
                //'user_id' =>  $request->user_id,
                'payment_mode' =>  $request->payment_mode,
            ]
        );
        TransactionController::createTransaction($request->merge(['type' => 'sale', 'amount' => $request->total_amount]));
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
        $sales =   Company::find($request->user_id)->sale;
        $name = Company::find($request->user_id);
        foreach ($sales as $sale) {
            $sale['updated_by'] = $name->company_name; //updated_by
            $transaction = Transaction::where('type', 'sale')->where('outer_id', $request->user_id)->first();
            $sale['transaction_id'] =  @$transaction->id;
            $sale['customer_name'] =  Customer::find($sale->customer_id)->name;
        }
        return response()->json(['response' => $sales, 'status' => 200]);
    }
}
