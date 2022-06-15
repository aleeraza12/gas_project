<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Forgotpassword;
use App\Models\Auth;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function basic_email(Request $request)
    {
        $company = Company::where('company_email', $request->email)->first();
        if ($company) {
            $code =  mt_rand(100000, 999999);
            $body = [
                'email' => $request['email'],
                'code' => $code,
                'subject' => 'Reset Password Mail'
            ];
            Mail::to($request->email)->send(new Forgotpassword($body));
            $auth = new Auth;
            $auth->otp = $code;
            $auth->email = $request->email;
            $auth->expire_at = Carbon::now()->addMinutes(30);
            $auth->save();
            return response()->json(['response' => 'Email sent successfully', 'status' => 200]);
        } else {
            return response()->json(['response' => 'There is no account related to this email', 'status' => 400]);
        }
    }

    public function verify_otp(Request $request)
    {
        $email = Company::where('company_email', $request->email)->first();
        $otp = Auth::where('email', $request->email)->where('otp', $request->otp)->first();
        if ($otp && $email) {
            $date2 = Carbon::create(Carbon::now());
            $date1 = Carbon::parse($otp->expire_at);
            if ($date1->lte($date2))
                return response()->json(['response' => 'OTP expired', 'status' => 400]);
            else {
                Auth::where('otp', $request->otp)->delete();
                return response()->json(['response' => 'OTP verified', 'status' => 200]);
            }
        } else
            return response()->json(['response' => 'Wrong OTP', 'status' => 400]);
    }

    public function update_password(Request $request)
    {
        $email = Company::where('company_email', $request->email)->first();
        $email->password = Hash::make($request->password);
        $email->save();
        return response()->json(['response' => 'Success', 'status' => 200]);
    }

    //public function html_email()
    //{
    //    $data = array('name' => "Virat Gandhi");
    //    FacadesMail::send('mail', $data, function ($message) {
    //        $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel HTML Testing Mail');
    //        $message->from('xyz@gmail.com', 'Virat Gandhi');
    //    });
    //    echo "HTML Email Sent. Check your inbox.";
    //}
    //public function attachment_email()
    //{
    //    $data = array('name' => "Virat Gandhi");
    //    FacadesMail::send('mail', $data, function ($message) {
    //        $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
    //        $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
    //        $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
    //        $message->from('xyz@gmail.com', 'Virat Gandhi');
    //    });
    //    echo "Email Sent with attachment. Check your inbox.";
    //}
}
