<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\liftreason;
class liftreasoncontroller extends Controller
{
    public function getliftreasons(Request $request)
    {
        // Fetch categories from the database
        $liftreasons = liftreason::all();

        // Return data as JSON
        return response()->json($liftreasons);
    }
}
