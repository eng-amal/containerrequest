<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\liftprority;
class liftproritycontroller extends Controller
{
    public function getliftproritys(Request $request)
    {
        // Fetch categories from the database
        $liftproritys = liftprority::all();

        // Return data as JSON
        return response()->json($liftproritys);
    }
}
