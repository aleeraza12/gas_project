<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class TokenVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $message = 'Invalid Credentials';
        if (empty($request->header('token')))
            $message = 'Invalid Credentials';
        $token = Token::where('token', $request->header('token'))->first();
        if ($token) {
            if ($request->user_id == $token->user_id) {
                $date2 = Carbon::create(Carbon::now());
                $date1 = Carbon::parse($token->expires_at);
                if ($date1->gte($date2))
                    return $next($request);
                else
                    $message = 'Your session expired';
            } else
                $message = 'Unauthenticated user';
        }
        return response()->json(['response' => $message, 'status' => 401]);
    }
}
