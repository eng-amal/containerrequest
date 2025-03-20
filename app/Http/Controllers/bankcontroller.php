<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bank;
class bankcontroller extends Controller
{
    public function getbanks(Request $request)
    {
        // Fetch categories from the database
        $banks = bank::all();

        // Return data as JSON
        return response()->json($banks);
    }
}
