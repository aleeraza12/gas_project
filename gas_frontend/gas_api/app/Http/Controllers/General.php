<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class General extends Controller
{
    public function Login(Request $request)
    {
        $is_admin = Company::where('company_email', $request->email)->first();
        $is_user = User::where('name', $request->email)->first();
        $status = 400;
        $message = [];
        if ($is_admin) { //if company & super admin
            if (Hash::check($request->password, $is_admin->password)) {
                if ($is_admin->status == "Active") {
                    $response = Token::create($request, $is_admin->id);
                    $message['token'] = $response[0];
                    $message['user'] = $is_admin;
                    $user_id = $is_admin->user;
                    $message['user']->user_id =  $user_id[0]->id;
                    $message['user']->user_type = 'Admin';
                    unset($message['user']['user']);
                    $status = 200;
                } else {
                    $message = "Your account is not approved yet";
                    $status = 400;
                }
            } else {
                $message = "Credentials didn't matched";
                $status = 400;
            }
        } else if (!$is_admin) { //if company created user
            if ($is_user && $is_user->status == "Active") {
                if (Hash::check($request->password, $is_user->password)) {
                    $response = Token::create($request, $is_user->company_id);
                    $message['token'] = $response[0];
                    $message['user'] = $is_user;
                    $company = Company::find($is_user->company_id);
                    $message['user']->company_name = $company->company_name;
                    $message['user']->address = $company->address;
                    $status = 200;
                } else {
                    $message = "Credentials didn't matched";
                    $status = 400;
                }
            } else {
                $message = "Credentials didn't matched";
                $status = 400;
            }
        } else if (!$is_admin && !$is_user) {
            $message = "User credentials does not match";
            $status = 400;
        }
        return response()->json(['data' => $message, 'status' => $status]);
    }
    public function Logout(Request $request)
    {
        Token::delete_token($request);
        return response()->json(['message' => 'User Logout successfully', 'status' => 200]);
    }

    public function get_dashboard_stats(Request $request)
    {
        $response['total_gas_quantity_purchase'] = Purchase::where('company_id', $request->company_id)->sum('gas_quantity');
        $response['total_gas_quantity_sale'] = Sale::where('company_id', $request->company_id)->sum('gas_quantity');
        $response['total_gas_quantity'] = $response['total_gas_quantity_purchase']  -  $response['total_gas_quantity_sale'];
        $response['total_gas_quantity'] <= 0 && $response['total_gas_quantity'] = 0;
        $purchase = Purchase::where('company_id', $request->company_id)->sum('amount');
        $response['total_customer'] = Customer::where('company_id', $request->company_id)->count();
        $response['total_sales'] = Sale::where('company_id', $request->company_id)->sum('total_amount');
        $response['total_gas_price'] =  $purchase -  $response['total_sales'];
        $response['total_gas_price'] <= 0 && $response['total_gas_price'] = 0;
        $response['new_customer'] = Customer::where('company_id', $request->company_id)->whereDate('created_at', date('Y-m-d'))->count();
        return response()->json(['response' => $response, 'status' => 200]);
    }

    public function get_dashboard_all(Request $request)
    {
        $response['total_gas_quantity'] = Purchase::sum('gas_quantity');
        $response['total_gas_price'] = Purchase::sum('amount');
        $response['total_customer'] = Customer::count();
        $response['total_sales'] = Sale::sum('total_amount');
        $response['new_customer'] = Customer::whereDate('created_at', date('Y-m-d'))->count();
        return response()->json(['response' => $response, 'status' => 200]);
    }
}
