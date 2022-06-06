<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
        if ($is_admin) {
            if (Hash::check($request->password, $is_admin->password)) {
                $response = Token::create($request, $is_admin->id);
                $message['token'] = $response[0];
                $message['user'] = $is_admin;
                $status = 200;
            } else {
                $message = "Credentials didn't matched";
                $status = 400;
            }
        } else if (!$is_admin) {
            if ($is_user) {
                if (Hash::check($request->password, $is_user->password)) {
                    $response = Token::create($request, $is_user->company_id);
                    $message['token'] = $response[0];
                    $message['user'] = $is_user;
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
}
