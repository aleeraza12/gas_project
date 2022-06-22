<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoRequest;
use App\Models\Company;
use App\Models\Promos;
use Illuminate\Http\Request;

class PromosController extends Controller
{
    public function create_promo(PromoRequest $request)
    {
        $promo = Promos::updateOrCreate(
            [
                'id' => $request->promo_id
            ],
            [
                'promo_name' => $request->promo_name,
                'promo_percentage' => $request->promo_percentage,
                'company_id' => $request->company_id,
            ]
        );
        return response()->json(['response' => $promo, 'status' => 201]);
    }

    public function delete_promo(Request $request)
    {
        Promos::find($request->promo_id)->delete();
        return response()->json(['response' => "Promo deleted successfully", 'status' => 200]);
    }

    public function read_promo(Request $request)
    {
        $promo =  Company::find($request->company_id)->promos()->whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        return response()->json(['response' => $promo, 'status' => 200]);
    }

    public function read_all_promos(Request $request)
    {
        $promos = Promos::whereBetween('created_at', array($request->start_date, $request->end_date))->get()->toArray();
        return response()->json(['response' => $promos, 'status' => 200]);
    }
}
