<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUp;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

    public function create_company(SignUp $request)
    {
        $company = Company::updateOrCreate(
            [
                'id' => $request->company_id
            ],
            [
                'owner_name' => $request->owner_name,
                'company_email' =>  $request->company_email,
                'company_name' =>  $request->company_name,
                'password' => Hash::make($request->password),
                'company_phone_number' =>  $request->company_phone_number,
                'city' =>  $request->city,
                'state' =>  $request->state,
                'gas_plant_type' =>  $request->gas_plant_type,
                'permissions' =>  ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'Settings'],
                //'company_profile_picture'=>  $this->upload_attachment($request),
                'address' =>  $request->address,
            ]
        );
        UserController::create_company_user($request->merge(['name' =>  $request->company_name, 'created_by' =>  $request->company_name, 'password' => $request->password, 'designation' => 'company', 'permissions' => ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases'], 'user_type' => 'admin', 'status' => 'active', 'user_id' => $company->id]));

        return response()->json(['response' => $company, 'status' => 201]);
    }

    public function delete_company(Request $request)
    {
        $company =  Company::find($request->company_id)->delete();
        return response()->json(['response' => "Customer deleted successfully", 'status' => 200]);
    }


    public function read_company(Request $request)
    {
        $company =  Company::find($request->company_id);
        return response()->json(['response' => $company, 'status' => 200]);
    }

    public function read(Request $request)
    {
        $companies =  Company::all();
        return response()->json(['response' => $companies, 'status' => 200]);
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
