<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users;
use App\Http\Requests\UserTypeRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create_user_type(UserTypeRequest $request)
    {
        $user_type = UserType::updateOrCreate(
            [
                'id' => $request->user_type_id
            ],
            [
                'user_type' => $request->user_type,
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
        $user_types =  UserType::all();
        return response()->json(['response' => $user_types, 'status' => 200]);
    }



    public function create_user(Users $request)
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
                'company_id' =>  $request->company_id,
                'is_company' => false,

            ]
        );
        return response()->json(['response' => $user, 'status' => 201]);
    }

    public static function create_company_user(Request $request)
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
                'company_id' =>  $request->company_id,
                'is_company' => true,
            ]
        );
        return $user;
    }

    public function delete_user(Request $request)
    {
        $user =  User::find($request->users_id)->delete();
        return response()->json(['response' => "User deleted successfully", 'status' => 200]);
    }

    //read specific user
    public function read_user(Request $request)
    {
        $user =  User::find($request->users_id);
        return response()->json(['response' => $user, 'status' => 200]);
    }

    //read all users for a company
    public function read_all_user(Request $request)
    {
        $users =  Company::find($request->company_id)->user()->where('is_company', false)->whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        return response()->json(['response' => $users, 'status' => 200]);
    }
    //read all users for super admn
    public function read(Request $request)
    {
        $users =  User::where('is_company', false)->whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        return response()->json(['response' => $users, 'status' => 200]);
    }
}
