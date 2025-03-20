<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contlocation;
class contlocationcontroller extends Controller
{
    public function getcontlocations(Request $request)
    {
        // Fetch categories from the database
        $contlocations = contlocation::all();

        // Return data as JSON
        return response()->json($contlocations);
    }
}
