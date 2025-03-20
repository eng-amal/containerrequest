<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\container;
class containercontroller extends Controller
{
    public function getcontainers(Request $request)
    {
        // Fetch categories from the database
        $firstSelectValue = $request->get('contsid');
        $options = container::where('status','=',0)->where('sizeid','=',$firstSelectValue)
        ->get(['id', 'no']);

        
        // Return the options as JSON
        return response()->json([
            'options' => $options
        ]);
    }
    public function getcontainers1(Request $request)
    {
        // Fetch categories from the database
        $firstSelectValue = $request->get('contsid');
        $options = container::where('sizeid','=',$firstSelectValue)
        ->get(['id', 'no']);

        
        // Return the options as JSON
        return response()->json([
            'options' => $options
        ]);
    }
}
