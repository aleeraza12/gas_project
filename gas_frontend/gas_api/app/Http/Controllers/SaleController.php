<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sales;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function create_sale(Sales $request)
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
                'payment_mode' =>  $request->payment_mode,
                'unpaid' => true,
                'unpaid_at' => Carbon::now()->addHours(5),
                'user_id' => $request->users_id, //loggedin user id
            ]
        );
        TransactionController::createTransaction($request->merge(['type' => 'sale', 'amount' => $request->total_amount, 'outer_id' => $request->sale_id ? $request->sale_id : $sale->id]));
        return response()->json(['response' => $sale, 'status' => 201]);
    }

    public function delete_sale(Request $request)
    {
        $sale =  Sale::find($request->sale_id)->delete();
        $sale =  Transaction::where("outer_id", $request->sale_id)->where("type", "sale")->delete();
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
            $transaction = Transaction::where('type', 'sale')->where('outer_id', $sale->id)->where('company_id', $request->user_id)->first();
            $sale['transaction_id'] =  @$transaction->id;
            $customer = Customer::find($sale->customer_id);
            $sale['customer_name'] =  $customer->name;
            $sale['customer_address'] =   $customer->address;
        }
        return response()->json(['response' => $sales, 'status' => 200]);
    }

    public function updateSale(Request $request)
    {
        $sale =  Sale::find($request->sale_id);
        $sale->gas_quantity = $request->gas_quantity;
        $sale->total_amount =  $request->total_amount;
        $sale->price =  $request->price;
        $sale->customer_id =  $request->customer_id;
        $sale->customer_phone_number =  $request->customer_phone_number;
        $sale->customer_type =  $request->customer_type;
        $sale->discount_code = $request->discount_code;
        $sale->company_id =  $request->user_id;
        $sale->payment_mode =  $request->payment_mode;
        $sale->save();
        TransactionController::updateSaleTransaction($request->merge([
            'amount' => $request->total_amount, 'outer_id' => $sale->id, 'type' => 'sale'
        ]));
        return response()->json(['response' => $sale, 'status' => 200]);
    }
    public function updateSaleStatus(Request $request)
    {
        $sale =  Sale::find($request->sale_id);
        $key = $value = null;
        if ($request->status == 'paid' && $sale->paid === null && $sale->delivered === null && $sale->unpaid !== null) {
            $key = 'paid';
            $value = 'paid_at';
        } else if ($request->status == 'delivered' && $sale->delivered === null && $sale->paid !== null && $sale->unpaid !== null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'paid' && $sale->delivered != null && $sale->paid != null) {
            $key = 'paid';
            $value = 'paid_at';
        } else if ($request->status == 'delivered' && $sale->delivered !== null && $sale->paid !== null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'delivered' && $sale->delivered !== null && $sale->paid === null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'delivered' && $sale->delivered == null && $sale->paid == null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'paid' && $sale->delivered != null && $sale->paid == null) {
            $key = 'paid';
            $value = 'paid_at';
        }
        $sale->update([$key => true, $value => Carbon::now()->addHours(5)]);
        return response()->json(['response' => $sale, 'status' => 200]);
    }
}
