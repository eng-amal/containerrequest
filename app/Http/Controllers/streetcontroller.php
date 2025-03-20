<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\street;
class streetcontroller extends Controller
{
   /* public function getstreets(Request $request)
    {
        // Fetch categories from the database
        $streets = street::all();

        // Return data as JSON
        return response()->json($streets);
    }*/

    public function getstreets(Request $request)
    {
        $firstSelectValue = $request->get('cityid');

        // Query based on the first dropdown value
        // Replace this with your actual model logic
        $options = street::where('cityid', $firstSelectValue)
                                     ->get(['id', 'name']);
        
        // Return the options as JSON
        return response()->json([
            'options' => $options
        ]);
    }
}
