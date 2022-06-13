<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auth;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail as FacadesMail;

class MailController extends Controller
{
    public function basic_email(Request $request)
    {
        $data = array('code' =>  mt_rand(100000, 999999),);

        FacadesMail::send(['text' => 'email.myTestMail'], $data, function ($message) use ($request) {
            $message->to($request->email, 'Reset Password')->subject('Reset Password mail');
            $message->from(config('app.reset_password_email'), 'GP');
        });
        $auth = new Auth;
        $auth->otp = $data['code'];
        $auth->email = $request->email;
        $auth->expire_at = Carbon::now();
        $auth->save();
        return response()->json(['response' => 'Email sent successfully', 'status' => 200]);
    }

    public function verify_otp(Request $request)
    {
        $otp = Auth::where('otp', $request->otp)->first();
        $email = Company::where('company_email', $request->email)->first();
        if ($otp && $email) {
            return response()->json(['response' => 'OTP verified', 'status' => 200]);
        } else {
            return response()->json(['response' => 'Wrong OTP', 'status' => 400]);
        }
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
