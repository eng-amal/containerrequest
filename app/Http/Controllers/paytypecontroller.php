<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paytype;
class paytypecontroller extends Controller
{
    public function getpaytypes(Request $request)
    {
        // Fetch categories from the database
        $paytypes = paytype::all();

        // Return data as JSON
        return response()->json($paytypes);
    }
}
