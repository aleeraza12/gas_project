<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function create_order(Request $request)
    {
        $order = Order::updateOrCreate(
            [
                'id' => $request->order_id
            ],
            [
                'gas_quantity' => $request->gas_quantity,
                'amount' =>  $request->amount,
                'customer_id' =>  $request->customer_id, //change customer name to id from model and migration
                'unit_price' =>  $request->unit_price,
                'status' =>  $request->status,
                'company_id' =>  $request->company_id,
                'user_id' =>  $request->users_id,
                'payment_mode' =>  $request->payment_mode,
                'order_id' =>  '0000000' . mt_rand(100, 999),
            ]
        );
        return response()->json(['response' => $order, 'status' => 201]);
    }

    public function delete_order(Request $request)
    {
        $order =  Order::find($request->order_id)->delete();
        return response()->json(['response' => "Order deleted successfully", 'status' => 200]);
    }


    public function read_order(Request $request)
    {
        $orders =  Company::find($request->company_id)->order()->whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        $company = Company::find($request->company_id);
        foreach ($orders as $order) {
            $order['company_name'] = $company->company_name;
            $order['updated_by'] = $company->company_name;
        }
        return response()->json(['response' => $orders, 'status' => 200]);
    }

    public function read_all_order(Request $request)
    {
        $orders =  Order::whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        return response()->json(['response' => $orders, 'status' => 200]);
    }
}
