<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\unemptyreason;
class unemptyreasoncontroller extends Controller
{
    public function getunemptyreasons(Request $request)
    {
        // Fetch categories from the database
        $unemptyreasons = unemptyreason::all();

        // Return data as JSON
        return response()->json($unemptyreasons);
    }
}
