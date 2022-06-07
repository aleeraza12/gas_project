<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\States;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    public function create_states(Request $request)
    {
        $states = States::updateOrCreate(
            [
                'id' => $request->states_id
            ],
            [
                'state_name' => $request->state_name,
            ]
        );
        return response()->json(['response' => $states, 'status' => 201]);
    }

    public function delete_states(Request $request)
    {
        States::find($request->states_id)->delete();
        return response()->json(['response' => "States deleted successfully", 'status' => 200]);
    }

    public function read_states(Request $request)
    {
        $states =  States::find($request->states_id);
        return response()->json(['response' => $states, 'status' => 200]);
    }

    public function read_all_states(Request $request)
    {
        $response = States::all();
        return response()->json(['response' => $response, 'status' => 200]);
    }
}
