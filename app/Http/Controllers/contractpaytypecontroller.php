<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contractpaytype;
class contractpaytypecontroller extends Controller
{
    public function getcontractpaytypes(Request $request)
    {
        // Fetch categories from the database
        $contractpaytypes = contractpaytype::all();

        // Return data as JSON
        return response()->json($contractpaytypes);
    }
}
