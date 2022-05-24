<?php

namespace App\Http\Controllers;

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
                'customer_id' =>  $request->customer_id,
                'unit_price' =>  $request->unit_price,
                'status' =>  $request->status,
                'user_id' =>  $request->user_id,
                'payment_mode_id' =>  $request->payment_mode_id,
                'payment_status_id' =>  $request->payment_status_id,
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
        $order =  Order::find($request->order_id);
        return response()->json(['response' => $order, 'status' => 200]);
    }

    public function read_all_order(Request $request)
    {
        $orders =  Order::all();
        return response()->json(['response' => $orders, 'status' => 200]);
    }
}
