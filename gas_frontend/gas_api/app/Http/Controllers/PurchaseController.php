<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function create_purchase(Request $request)
    {
        $purchase = Purchase::updateOrCreate(
            [
                'id' => $request->purchase_id
            ],
            [
                'date' => $request->date,
                'receipt_number' =>  $request->receipt_number,
                'company_name' =>  $request->company_name,
                'company_phone_name' => $request->company_phone_name,
                'driver_name' =>  $request->driver_name,
                'gas_quantity' =>  $request->gas_quantity,
                'amount' =>  $request->amount,
                'unit_price' =>  $request->unit_price,
                'status' =>  $request->status,
                'user_id' =>  $request->user_id,
                'payment_status_id' =>  $request->payment_status_id,
                'receipt_attachment_path' =>  $this->upload_attachment($request),
            ]
        );
        return response()->json(['response' => $purchase, 'status' => 201]);
    }

    public function delete_purchase(Request $request)
    {
        $purchase =  Purchase::find($request->purchase_id)->delete();
        return response()->json(['response' => "Purchase deleted successfully", 'status' => 200]);
    }


    public function read_purchase(Request $request)
    {
        $purchase =  Purchase::find($request->purchase_id);
        return response()->json(['response' => $purchase, 'status' => 200]);
    }

    public function read_all_purchases(Request $request)
    {
        $purchases =  Purchase::all();
        return response()->json(['response' => $purchases, 'status' => 200]);
    }

    public function upload_attachment($request)
    {
        $filename = Str::random(5) . 'id' . $request->date . '.' . $request->extension;
        $original_file_path = 'receipt' . $filename;
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $request->attachment);
        $image = str_replace(' ', '+', $image);
        Storage::disk('local')->put($original_file_path, base64_decode($image));
        return $original_file_path;
    }
}
