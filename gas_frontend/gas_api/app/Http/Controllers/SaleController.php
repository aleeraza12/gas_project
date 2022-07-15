<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sales;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Promos;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{

    public function create_sale(Sales $request)
    {
        if ($request->discount_code != null) {
            $promo = Promos::where('company_id', $request->company_id)->where('promo_name', $request->discount_code)->first();
            if ($promo == null)
                return response()->json(['response' => 'Invalid discount code', 'status' => 400]);
        }


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
                'company_id' =>  $request->company_id,
                'payment_mode' =>  $request->payment_mode,
                'amount_being_paid' => $request->amount_being_paid,
                'balance' => $request->balance,
                'unpaid' => true,
                'unpaid_at' => Carbon::now()->addHours(1),
                'user_id' => $request->users_id, //loggedin user id
            ]
        );
        if ($request->discount_code != null) {
            $promo = Promos::where('company_id', $request->company_id)->where('promo_name', $request->discount_code)->first();
            $discount = $promo->promo_percentage / 100 * $request->total_amount;
            Sale::find($sale->id)->update(['discounted_amount' => $request->total_amount - $discount]);
        } else if ($request->discount_code == null) {
            Sale::find($sale->id)->update(['discounted_amount' => $request->total_amount]);
        }
        if ($request->payment_mode != 'Credit') {
            Sale::find($sale->id)->update(['paid' => true, 'paid_at' => Carbon::now()->addHours(1)]);
        }
        TransactionController::createTransaction($request->merge(['type' => 'sale', 'amount' => $request->total_amount, 'outer_id' => $request->sale_id ? $request->sale_id : $sale->id]));
        $sale = $this->read_sale($request, $sale);

        return response()->json(['response' => $sale, 'status' => 201]);
    }

    public function delete_sale(Request $request)
    {
        $sale =  Sale::find($request->sale_id)->delete();
        $sale =  Transaction::where("outer_id", $request->sale_id)->where("type", "sale")->delete();
        return response()->json(['response' => "Sale deleted successfully", 'status' => 200]);
    }


    public function read_sale($request, $sale)
    {
        $sale =  Sale::find($sale->id)->first();
        $name = Company::find($request->company_id);
        $sale['updated_by'] = User::find($request->users_id)->name; //updated_by
        $transaction = Transaction::where('type', 'sale')->where('outer_id', $sale->id)->where('company_id', $request->company_id)->first();
        $sale['transaction_id'] =  @$transaction->id;
        $customer = Customer::find($sale->customer_id);
        $promo = Promos::withTrashed()->where('company_id', $request->company_id)->where('promo_name', $sale->discount_code)->first();
        $sale['promo_id'] =  @$promo->id;
        $sale['customer_name'] =  $customer->name;
        $sale['customer_address'] =   $customer->address;
        $sale['company_profile_picture']   = $name['company_profile_picture'];
        $sale['company_address']   = $name['address'];
        $sale['company_name']   = $name['company_name'];
        return $sale;
    }
    //for companes
    public function read_all_sale(Request $request)
    {
        $sales =   Company::find($request->company_id)->sale()->whereBetween('created_at', array($request->start_date, $request->end_date))->get();
        $name = Company::find($request->company_id);
        foreach ($sales as $sale) {
            $sale['updated_by'] = User::find($sale->user_id)->name; //updated_by
            $transaction = Transaction::where('type', 'sale')->where('outer_id', $sale->id)->where('company_id', $request->company_id)->first();
            $sale['transaction_id'] =  @$transaction->id;
            $customer = Customer::find($sale->customer_id);
            $promo = Promos::withTrashed()->where('company_id', $request->company_id)->where('promo_name', $sale->discount_code)->first();
            $sale['promo_id'] =  @$promo->id;
            $sale['customer_name'] =  $customer->name;
            $sale['customer_address'] =   $customer->address;
            $sale['company_profile_picture']   = $name['company_profile_picture'];
            $sale['company_address']   = $name['address'];
            $sale['company_name']   = $name['company_name'];
        }
        return response()->json(['response' => $sales, 'status' => 200]);
    }
    //for super admn
    public function read(Request $request)
    {
        $sales =  Sale::whereBetween('created_at', array($request->start_date, $request->end_date))->get();
        foreach ($sales as $sale) {
            $name = Company::find($sale->company_id);
            $sale['updated_by'] = User::find($sale->user_id)->name; //updated_by
            $transaction = Transaction::where('type', 'sale')->where('outer_id', $sale->id)->where('company_id', $sale->company_id)->first();
            $promo = Promos::withTrashed()->where('company_id', $sale->company_id)->where('promo_name', $sale->discount_code)->first();
            $sale['promo_id'] =  @$promo->id;
            $sale['transaction_id'] =  @$transaction->id;
            $customer = Customer::find($sale->customer_id);
            $sale['customer_name'] =  $customer->name;
            $sale['customer_address'] =   $customer->address;
            $sale['company_profile_picture']   = $name['company_profile_picture'];
            $sale['company_address']   = $name['address'];
            $sale['company_name']   = $name['company_name'];
        }
        return response()->json(['response' => $sales, 'status' => 200]);
    }

    public function updateSale(Request $request)
    {
        if ($request->discount_code != null) {
            $promo = Promos::where('company_id', $request->company_id)->where('promo_name', $request->discount_code)->first();
            if ($promo == null)
                return response()->json(['response' => 'Invalid discount code', 'status' => 400]);
        }
        $sale =  Sale::find($request->sale_id);
        $sale->gas_quantity = $request->gas_quantity;
        $sale->total_amount =  $request->total_amount;
        $sale->price =  $request->price;
        $sale->customer_id =  $request->customer_id;
        $sale->customer_phone_number =  $request->customer_phone_number;
        $sale->customer_type =  $request->customer_type;
        $sale->discount_code = $request->discount_code;
        $sale->amount_being_paid = $request->amount_being_paid;
        $sale->balance = $request->balance;
        $sale->company_id =  $request->company_id;
        $sale->payment_mode =  $request->payment_mode;
        $sale->save();
        if ($request->discount_code != null) {
            $promo = Promos::withTrashed()->where('company_id', $request->company_id)->where('promo_name', $request->discount_code)->first();
            $discount = $promo->promo_percentage / 100 * $request->total_amount;
            Sale::find($request->sale_id)->update(['discounted_amount' => $request->total_amount - $discount]);
        } else if ($request->discount_code == null) {
            Sale::find($sale->id)->update(['discounted_amount' => $request->total_amount]);
        }
        TransactionController::updateSaleTransaction($request->merge([
            'amount' => $request->total_amount, 'outer_id' => $sale->id, 'company_id' => $request->company_id, 'type' => 'sale'
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

        $sale->update([$key => true, $value => Carbon::now()->addHours(1)]);
        if ($key == 'paid') TransactionController::updateTransaction($request->merge([
            'outer_id' => $request->sale_id, 'type' => 'sale'
        ]));
        return response()->json(['response' => $sale, 'status' => 200]);
    }
}
