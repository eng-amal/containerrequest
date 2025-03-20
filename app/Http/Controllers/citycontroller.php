<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\city;
class citycontroller extends Controller
{
    public function getcities(Request $request)
    {
        // Fetch categories from the database
        $cities = city::all();

        // Return data as JSON
        return response()->json($cities);
    }
}
