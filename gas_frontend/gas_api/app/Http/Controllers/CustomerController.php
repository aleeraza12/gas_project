<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customers;
use App\Http\Requests\CustomerTypeRequest;
use App\Models\Company;
use App\Models\Customer as CustomerModel;
use App\Models\CustomerType;
use App\Models\Sale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create_customer_type(CustomerTypeRequest $request)
    {
        $customer_type = CustomerType::updateOrCreate(
            [
                'id' => $request->customer_type_id
            ],
            [
                'customer_type' => $request->customer_type
            ]
        );
        return response()->json(['response' => $customer_type, 'status' => 201]);
    }

    public function delete_customer_type(Request $request)
    {
        $hotel =  CustomerType::find($request->customer_type_id)->delete();
        return response()->json(['response' => "Customer type deleted successfully", 'status' => 200]);
    }

    public function read_customer_type(Request $request)
    {
        $customer_type =  CustomerType::find($request->customer_type_id);
        return response()->json(['response' => $customer_type, 'status' => 200]);
    }

    public function read_all_customer_type(Request $request)
    {
        $customer_types = CustomerType::all();
        return response()->json(['response' => $customer_types, 'status' => 200]);
    }

    public function create_customer(Customers $request)
    {
        $customer = CustomerModel::updateOrCreate(
            [
                'id' => $request->customer_id
            ],
            [
                'name' => $request->name,
                'email' =>  $request->email,
                'phone_number' =>  $request->phone_number,
                'city' =>  $request->city,
                'state' =>  $request->state,
                //'customer_type_id'=>  $request->customer_type_id,
                'customer_type' =>  $request->customer_type,
                'company_id' =>  $request->company_id,
                'address' =>  $request->address,
            ]
        );
        return response()->json(['response' => $customer, 'status' => 201]);
    }

    public function delete_customer(Request $request)
    {
        $customer =  CustomerModel::find($request->customer_id)->delete();
        return response()->json(['response' => "Customer deleted successfully", 'status' => 200]);
    }


    public function read_customer(Request $request)
    {
        $customer =  CustomerModel::find($request->customer_id);
        return response()->json(['response' => $customer, 'status' => 200]);
    }

    public function read(Request $request)
    {
        $customers = CustomerModel::whereBetween('created_at', array($request->start_date, $request->end_date))->get();
        foreach ($customers as $customer) {
            $customer['total_sale'] = Sale::where('customer_id', $customer->id)->sum('total_amount');
        }
        return response()->json(['response' => $customers, 'status' => 200]);
    }

    public function read_all_customer(Request $request)
    {
        $customers = Company::find($request->company_id)->customer()->whereBetween('created_at', array($request->start_date, $request->end_date))->get();
        foreach ($customers as $customer) {
            $customer['total_sale'] = Sale::where('customer_id', $customer->id)->sum('total_amount');
        }
        return response()->json(['response' => $customers, 'status' => 200]);
    }
}
