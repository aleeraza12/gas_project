<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PaymentMode;
use App\Models\PaymentStatus;
use Illuminate\Http\Request;

class Payment extends Controller
{

    //CRUD for Payment Mode like cash,prepaid
    public function create_payment_mode(Request $request)
    {
        $payment_mode = PaymentMode::updateOrCreate(
            [
                'id' => $request->payment_mode_id
            ],
            [
                'payment_mode' => $request->payment_mode,
            ]
        );
        return response()->json(['response' => $payment_mode, 'status' => 201]);
    }

    public function delete_payment_mode(Request $request)
    {
        PaymentMode::find($request->payment_mode_id)->delete();
        return response()->json(['response' => "Payment Mode deleted successfully", 'status' => 200]);
    }

    public function read_payment_mode(Request $request)
    {
        $payment_mode =  PaymentMode::find($request->payment_mode_id);
        return response()->json(['response' => $payment_mode, 'status' => 200]);
    }

    public function read_all_payment_mode(Request $request)
    {
        $payment_modes = PaymentMode::all();

        return response()->json(['response' => $payment_modes, 'status' => 200]);
    }

    //CRUD for Payment Status like paid,unpaid
    public function create_payment_status(Request $request)
    {
        $payment_status = PaymentStatus::updateOrCreate(
            [
                'id' => $request->payment_status_id
            ],
            [
                'payment_status' => $request->payment_status,
            ]
        );
        return response()->json(['response' => $payment_status, 'status' => 201]);
    }

    public function delete_payment_status(Request $request)
    {
        PaymentStatus::find($request->payment_status_id)->delete();
        return response()->json(['response' => "Payment Status deleted successfully", 'status' => 200]);
    }

    public function read_payment_status(Request $request)
    {
        $payment_status =  PaymentStatus::find($request->payment_status_id);
        return response()->json(['response' => $payment_status, 'status' => 200]);
    }

    public function read_all_payment_status()
    {
        $payment_statuses =  PaymentStatus::all();
        return response()->json(['response' => $payment_statuses, 'status' => 200]);
    }
}
