<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\liftreason;
class unliftreasoncontroller extends Controller
{
    public function getunliftreasons(Request $request)
    {
        // Fetch categories from the database
        $unliftreasons = unliftreason::all();

        // Return data as JSON
        return response()->json($unliftreasons);
    }
}
