<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bldeh;
class bldehcontroller extends Controller
{
    public function getbldehs(Request $request)
    {
        // Fetch categories from the database
        $bldehs = bldeh::all();

        // Return data as JSON
        return response()->json($bldehs);
    }
}
