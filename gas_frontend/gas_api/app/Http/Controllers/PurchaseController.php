<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
                'company_phone_number' => $request->company_phone_number,
                'driver_name' =>  $request->driver_name,
                'gas_quantity' =>  $request->gas_quantity,
                'amount' =>  $request->amount,
                'unit_price' =>  $request->unit_price,
                'recepient_name' =>  $request->recepient_name,
                'company_id' => $request->user_id,
                'receipt_attachment_path' =>  $request->has('attachment') ? $this->upload_attachment($request) : null,
            ]
        );
        TransactionController::createTransaction($request->merge(['type' => 'purchase']));
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
        $purchases =  Company::find($request->user_id)->purchase;
        foreach ($purchases as $purchase) {
            $purchase['base64'] = base64_encode(Storage::get($purchase['receipt_attachment_path']));
        }
        return response()->json(['response' => $purchases, 'status' => 200]);
    }

    public function upload_attachment($request)
    {
        $filename = Str::random(5) . 'id' . $request->date . '.' . 'png';
        $original_file_path = 'receipt' . $filename;
        $image = $request->attachment;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $request->attachment);
        $image = str_replace(' ', '+', $image);
        Storage::disk('local')->put($original_file_path, base64_decode($image));
        return $original_file_path;
    }
}
