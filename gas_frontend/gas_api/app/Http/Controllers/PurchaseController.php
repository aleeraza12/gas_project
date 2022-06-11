<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchases;
use App\Models\Company;
use App\Models\Purchase;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function create_purchase(Purchases $request)
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
                'company_id' => $request->company_id, //company id
                'user_id' => $request->users_id, //loggedin user id
                'unpaid' => true,
                'unpaid_at' => Carbon::now()->addHours(5),
                'receipt_attachment_path' =>  $request->attachment == "" ? null :  $this->upload_attachment($request)
            ]
        );
        TransactionController::createTransaction($request->merge(['type' => 'purchase', 'amount' => $request->amount, 'outer_id' => $purchase->id]));
        return response()->json(['response' => $purchase, 'status' => 201]);
    }

    public function delete_purchase(Request $request)
    {
        $purchase =  Purchase::find($request->purchase_id)->delete();
        $purchase =  Transaction::where("outer_id", $request->purchase_id)->where("type", "purchase")->delete();
        return response()->json(['response' => "Purchase deleted successfully", 'status' => 200]);
    }


    public function read_purchase(Request $request)
    {
        $purchase =  Purchase::find($request->purchase_id);
        return response()->json(['response' => $purchase, 'status' => 200]);
    }

    public function read_all_purchases(Request $request)
    {
        $purchases =  Company::find($request->company_id)->purchase;
        foreach ($purchases as $purchase) {
            if ($purchase['receipt_attachment_path'] !== null)
                $purchase['base64'] = base64_encode(Storage::get($purchase['receipt_attachment_path']));
            $transaction = Transaction::where('type', 'purchase')->where('outer_id', $request->company_id)->first();
            $purchase['transaction_id'] =  @$transaction->id;
        }
        return response()->json(['response' => $purchases, 'status' => 200]);
    }

    public function read(Request $request)
    {
        $purchases =  Purchase::all();
        foreach ($purchases as $purchase) {
            if ($purchase['receipt_attachment_path'] !== null)
                $purchase['base64'] = base64_encode(Storage::get($purchase['receipt_attachment_path']));
            $transaction = Transaction::where('type', 'purchase')->where('outer_id', $request->company_id)->first();
            $purchase['transaction_id'] =  @$transaction->id;
        }
        return response()->json(['response' => $purchases, 'status' => 200]);
    }


    public function update_purchase(Purchases $request)
    {
        $purchase =  Purchase::find($request->purchase_id);
        $purchase->date = $request->date;
        $purchase->receipt_number =  $request->receipt_number;
        $purchase->company_name =  $request->company_name;
        $purchase->company_phone_number = $request->company_phone_number;
        $purchase->driver_name =  $request->driver_name;
        $purchase->gas_quantity =  $request->gas_quantity;
        $purchase->amount =  $request->amount;
        $purchase->unit_price =  $request->unit_price;
        $purchase->recepient_name =  $request->recepient_name;
        $purchase->company_id = $request->company_id;
        $purchase->user_id = $request->users_id;
        $purchase->receipt_attachment_path =  $request->attachment == "" ? null :  $this->upload_attachment($request);
        $purchase->save();
        TransactionController::updateSaleTransaction($request->merge([
            'amount' => $request->amount, 'outer_id' => $request->purchase_id, 'type' => 'purchase'
        ]));
        return response()->json(['response' => $purchase, 'status' => 200]);
    }

    public function updatePurchaseStatus(Request $request)
    {
        $purchase =  Purchase::find($request->purchase_id);
        $key = $value = null;
        if ($request->status == 'paid' && $purchase->paid === null && $purchase->delivered === null && $purchase->unpaid !== null) {
            $key = 'paid';
            $value = 'paid_at';
        } else if ($request->status == 'delivered' && $purchase->delivered === null && $purchase->paid !== null && $purchase->unpaid !== null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'paid' && $purchase->delivered != null && $purchase->paid != null) {
            $key = 'paid';
            $value = 'paid_at';
        } else if ($request->status == 'delivered' && $purchase->delivered !== null && $purchase->paid !== null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'delivered' && $purchase->delivered !== null && $purchase->paid === null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'delivered' && $purchase->delivered == null && $purchase->paid == null) {
            $key = 'delivered';
            $value = 'delivered_at';
        } else if ($request->status == 'paid' && $purchase->delivered != null && $purchase->paid == null) {
            $key = 'paid';
            $value = 'paid_at';
        }
        $receipt_attachment_path = null;
        if ($request->attachment != "")
            $receipt_attachment_path =  $this->upload_attachment($request);
        $purchase->update([$key => true, $value => Carbon::now()->addHours(5), 'receipt_attachment_path' => $receipt_attachment_path]);
        if ($key == 'paid') TransactionController::updateTransaction($request->merge([
            'outer_id' => $request->purchase_id, 'type' => 'purchase'
        ]));
        return response()->json(['response' => $purchase, 'status' => 200]);
    }

    public function upload_attachment($request)
    {
        $filename = Str::random(5) . 'id' . '.' . 'png';
        $original_file_path = 'receipt' . $filename;
        $image = $request->attachment;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $request->attachment);
        $image = str_replace(' ', '+', $image);
        Storage::disk('local')->put($original_file_path, base64_decode($image));
        return $original_file_path;
    }
}
