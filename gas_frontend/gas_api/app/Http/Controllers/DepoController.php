<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Depos;
use Illuminate\Http\Request;

class DepoController extends Controller
{

    //CRUD for Depo prices
    public function create_depo_price(Request $request)
    {
        $depo = new Depos;
        $depo->depo_name = $request->depo_name;
        $depo->price_per_twenty_million_ton = $request->price_per_twenty_million_ton;
        $depo->location = $request->location;
        $depo->added_by_admin = (bool)$request->added_by_admin;
        $depo->company_id = $request->company_id;
        $depo->save();
        return response()->json(['response' => $depo, 'status' => 201]);
    }

    public function update_depo_price(Request $request)
    {
        $depo = Depos::find($request->depo_id);
        $depo->depo_name = $request->depo_name;
        $depo->price_per_twenty_million_ton = $request->price_per_twenty_million_ton;
        $depo->location = $request->location;
        $depo->added_by_admin = (bool)$request->added_by_admin;
        $depo->company_id = $request->company_id;
        $depo->save();
        return response()->json(['response' => $depo, 'status' => 201]);
    }

    public function delete_depo_price(Request $request)
    {
        if (!$request->added_by_admin)
            return response()->json(['response' => "Unauthenticated action", 'status' => 400]);
        Depos::find($request->depo_id)->delete();
        return response()->json(['response' => "Depo price deleted successfully", 'status' => 200]);
    }

    public function read_depo_price(Request $request)
    {
        $depo_price =   Company::find($request->company_id)->depos()->OrderByDesc('created_at')->first();
        return response()->json(['response' => $depo_price, 'status' => 200]);
    }

    public function read_company_depos(Request $request)
    {
        $depo_prices =   Company::find($request->company_id)->depos()->where('added_by_admin', false)->get()->toArray();
        return response()->json(['response' => $depo_prices, 'status' => 200]);
    }

    public function read_all_depo_prices_admin()
    {
        $depo_prices =  Depos::where('added_by_admin', false)->get()->toArray();
        return response()->json(['response' => $depo_prices, 'status' => 200]);
    }
    public function read_rate_list(Request $request)
    {
        $depo_prices =  Depos::where('added_by_admin', true)->whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        return response()->json(['response' => $depo_prices, 'status' => 200]);
    }
}
