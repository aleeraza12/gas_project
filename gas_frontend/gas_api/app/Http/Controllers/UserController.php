<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create_user_type(Request $request)
    {
        $user_type = UserType::updateOrCreate(
            [
                'id' => $request->user_type_id
            ],
            [
                'user_type' => $request->user_type,
                'company_id' => $request->user_id,
            ]
        );
        return response()->json(['response' => $user_type, 'status' => 201]);
    }

    public function delete_user_type(Request $request)
    {
        $hotel =  UserType::find($request->user_type_id)->delete();
        return response()->json(['response' => "User type deleted successfully", 'status' => 200]);
    }

    public function read_user_type(Request $request)
    {
        $user_type =  UserType::find($request->user_type_id);
        return response()->json(['response' => $user_type, 'status' => 200]);
    }

    public function read_all_user_type(Request $request)
    {
        $user_types =  Company::find($request->user_id)->user_type;
        return response()->json(['response' => $user_types, 'status' => 200]);
    }



    public function create_user(Request $request)
    {
        $user = User::updateOrCreate(
            [
                'id' => $request->users_id
            ],
            [
                'name' => $request->name,
                'created_by' => $request->created_by,
                'password' => Hash::make($request->password),
                'designation' =>  $request->designation,
                'permissions' =>  $request->permissions,
                'user_type' =>  $request->user_type,
                'status' =>  $request->status,
                //'user_type_id'=>  $request->user_type_id,
                'company_id' =>  $request->user_id,
            ]
        );
        return response()->json(['response' => $user, 'status' => 201]);
    }

    public function delete_user(Request $request)
    {
        $user =  User::find($request->users_id)->delete();
        return response()->json(['response' => "User deleted successfully", 'status' => 200]);
    }


    public function read_user(Request $request)
    {
        $user =  User::find($request->users_id);
        return response()->json(['response' => $user, 'status' => 200]);
    }

    public function read_all_user(Request $request)
    {
        $users =  Company::find($request->user_id)->user;
        return response()->json(['response' => $users, 'status' => 200]);
    }
}
