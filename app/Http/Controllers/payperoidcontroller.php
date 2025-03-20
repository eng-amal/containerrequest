<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payperoid;
class payperoidcontroller extends Controller
{
    public function getpayperoids(Request $request)
    {
        // Fetch categories from the database
        $payperoids = payperoid::all();

        // Return data as JSON
        return response()->json($payperoids);
    }
}
