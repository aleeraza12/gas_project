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
        $depo_price = Depos::updateOrCreate(
            [
                'id' => $request->depo_id
            ],
            [
                'depo_name' => $request->depo_name,
                'price_per_twenty_million_ton' => $request->price_per_twenty_million_ton,
                'location' => $request->location,
                'company_id' =>  $request->company_id,

            ]
        );
        return response()->json(['response' => $depo_price, 'status' => 201]);
    }

    public function delete_depo_price(Request $request)
    {
        Depos::find($request->depo_id)->delete();
        return response()->json(['response' => "Depo price deleted successfully", 'status' => 200]);
    }

    public function read_depo_price(Request $request)
    {
        $depo_price =  Company::find($request->company_id)->depos;
        return response()->json(['response' => $depo_price, 'status' => 200]);
    }

    public function read_all_depo_prices()
    {
        $depo_prices =  Depos::all();
        return response()->json(['response' => $depo_prices, 'status' => 200]);
    }
}
