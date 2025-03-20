<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\containersize;
class containersizeController extends Controller
{
    public function getcontainersizes(Request $request)
    {
        // Fetch categories from the database
        $containersizes = containersize::all();

        // Return data as JSON
        return response()->json($containersizes);
    }
}
