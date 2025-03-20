<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contsizecost;
class contsizecostcontroller extends Controller
{
    public function getCost(Request $request)
    {
        $contsizeid = $request->contsizeid;
        $rent = $request->rent;

        $costEntry = contsizecost::where('contsizeid', $contsizeid)
            ->where('fday', '<=', $rent)
            ->where('tday', '>=', $rent)
            ->first();

        if ($costEntry) {
            return response()->json(['cost' => $costEntry->cost]);
        } else {
            return response()->json(['cost' => null]);
        }
    }
}
