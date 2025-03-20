<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wastetype;
class wastetypecontroller extends Controller
{
    public function getwastetypes(Request $request)
    {
        // Fetch categories from the database
        $wastetypes = wastetype::all();

        // Return data as JSON
        return response()->json($wastetypes);
    }
}
