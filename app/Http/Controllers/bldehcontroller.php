<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bldeh;
class bldehcontroller extends Controller
{
    public function getbldehs(Request $request)
    {
        // Fetch categories from the database
        $bldehs = bldeh::all();

        // Return data as JSON
        return response()->json($bldehs);
    }
    public function bldehindex()
    {
        $bldehs = bldeh::all();
            
            return view('bldehindex', compact('bldehs'));
    }
    public function createbldeh()
    {
       
        return view('createbldeh');
    }
    public function storebldeh(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',

            ]);
       
        bldeh::create($request->post());
        return redirect()->route('bldehindex')->with('success','bldeh has been created successfully.');
    }
    
    public function destroybldeh($id)
    {
        $bldeh = bldeh::findOrFail($id);
        $bldeh->delete();
        return redirect()->route('bldehindex')->with('success','bldeh Has Been deleted successfully');;
    }
}
