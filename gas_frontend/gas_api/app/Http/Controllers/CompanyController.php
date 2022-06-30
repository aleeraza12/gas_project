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
        $super_adm_company = Company::where('is_super_admin', true)->first();
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
                'is_super_admin' =>   $request->company_email ==  $super_adm_company->company_email ? true : false,
                'permissions' =>  $request->company_email == $super_adm_company->company_email  ? ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Rates', 'Sales', 'Purchases', 'AdminSettings', 'Companies', 'Promos', 'Rate List'] : ['Dashboard', 'Orders', 'Users', 'Rates', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'Settings', 'Promos', 'Rate List'],
                'company_profile_picture' =>  $request->attachment == "" ? null :  $this->upload_attachment($request),
                'address' =>  $request->address,
            ]
        );
        //if company is created first time than we create user
        if (!$request->company_id) {
            $user = UserController::create_company_user($request->merge(['name' =>  $request->company_name, 'created_by' =>  $request->company_name, 'password' => $request->password, 'designation' => 'company', 'permissions' => ['Dashboard', 'Orders', 'Users', 'Rates', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'Promos', 'Rate List'], 'user_type' => 'admin', 'status' => 'Active', 'company_id' => $company->id]));
            $seeder = new \Database\Seeders\OrderSeeder();
            $seeder->run($company->id, $user->id);
        }
        return response()->json(['response' => $company, 'status' => 201]);
    }

    public function getAttachment($company)
    {
        if ($company['company_profile_picture'] !== null)
            return base64_encode(Storage::get($company['company_profile_picture']));
    }
    public function delete_company(Request $request)
    {
        $company =  Company::find($request->company_id)->delete();
        return response()->json(['response' => "Company deleted successfully", 'status' => 200]);
    }


    public function read_company(Request $request)
    {
        $company =  Company::find($request->company_id);
        return response()->json(['response' => $company, 'status' => 200]);
    }

    public function read(Request $request)
    {
        $companies =  Company::whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        return response()->json(['response' => $companies, 'status' => 200]);
    }

    public function upload_attachment($request)
    {
        $filename = Str::random(5) . 'id' . $request->date . '.' . 'png';
        $original_file_path = 'company_profile' . $filename;
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $request->attachment);
        $image = str_replace(' ', '+', $image);
        Storage::disk('local')->put($original_file_path, base64_decode($image));
        return $original_file_path;
    }
}
