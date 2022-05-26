<?php

namespace App\Http\Controllers;

use App\Models\Depo;
use Illuminate\Http\Request;

class DepoController extends Controller
{

    //CRUD for Depo prices
    public function create_depo_price(Request $request)
    {
        $depo_price = Depo::updateOrCreate(
            [
                'id' => $request->depo_id
            ],
            [
                'price_per_million_ton' => $request->price_per_million_ton,
                'location' => $request->location,
            ]
        );
        return response()->json(['response' => $depo_price, 'status' => 201]);
    }

    public function delete_depo_price(Request $request)
    {
        Depo::find($request->depo_id)->delete();
        return response()->json(['response' => "Depo price deleted successfully", 'status' => 200]);
    }

    public function read_depo_price(Request $request)
    {
        $depo_price =  Depo::find($request->depo_id);
        return response()->json(['response' => $depo_price, 'status' => 200]);
    }

    public function read_all_depo_prices()
    {
        $depo_prices =  Depo::all();
        return response()->json(['response' => $depo_prices, 'status' => 200]);
    }
}
