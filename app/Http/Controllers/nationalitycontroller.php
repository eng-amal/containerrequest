<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nationality;
class nationalitycontroller extends Controller
{
    public function getnationalitys(Request $request)
    {
        // Fetch categories from the database
        $nationalitys = nationality::all();

        // Return data as JSON
        return response()->json($nationalitys);
    }
}
