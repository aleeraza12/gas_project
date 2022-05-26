<?php


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
namespace App\Models;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Token extends Model
{
    

    protected $fillable = [
        'token',
        'user_id',
        'last_used_at'
    ];

    /**
     * This function used to create token for MDMS user
     * Than we set token expiry time
     * A token will be created along user unique id
     *  
     * @param Request $request,$id
     * @return $token and status_code
     */
    public static function create($request, $id)
    {
        $random_token = Str::random(61);
        $token = new Token();
        $token->token = $random_token;
        $token->expires_at = $token->expires_at = Carbon::create(Carbon::now()->addHours(5)->format('Y-m-d\TH:i:sO'));
        $token->user_id = $id;
        $token->save();
        return [$token->token, 201];
    }

    /**
     * This function used to delete token whenever user logout
     *  
     * @param Request $request
     * @return $empty array and status_code
     */
    public function delete_token($request)
    {
        Token::where('token', $request->header('token'))->delete();
        return [(object)[], 200];
    }

      
}