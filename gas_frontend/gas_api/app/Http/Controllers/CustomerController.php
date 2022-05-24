<?php

namespace App\Http\Controllers;

use App\Models\Customer as CustomerModel;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function create_customer_type(Request $request)
    {
        $customer_type = CustomerType::updateOrCreate(
            [
                'id' => $request->customer_type_id
            ],
            [
                'customer_type' => $request->customer_type,
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
        $customer_types =  CustomerType::all();
        return response()->json(['response' => $customer_types, 'status' => 200]);
    }

    public function create_customer(Request $request)
    {
        $customer = CustomerModel::updateOrCreate(
            [
                'id' => $request->customer_id
            ],
            [
                'name' => $request->name,
                'email' =>  $request->email,
                'phone_number'=>  $request->phone_numer,
                'password'=> Hash::make($request->password),
                'city'=>  $request->city,
                'state'=>  $request->state,
                'customer_type_id'=>  $request->customer_type_id,
                'address'=>  $request->address,
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

       public function read_all_customer(Request $request)
    {
        $customers =  CustomerModel::all();
        return response()->json(['response' => $customers, 'status' => 200]);
    }

}
