<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\city;
class citycontroller extends Controller
{
    public function getcities(Request $request)
    {
        // Fetch categories from the database
        $cities = city::all();

        // Return data as JSON
        return response()->json($cities);
    }
    public function cityindex()
    {
        $citys = city::all();
            
            return view('cityindex', compact('citys'));
    }
    public function createcity()
    {
       
        return view('createcity');
    }
    public function storecity(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',

            ]);
       
        city::create($request->post());
        return redirect()->route('cityindex')->with('success','city has been created successfully.');
    }
    
    public function destroycity($id)
    {
        $city = city::findOrFail($id);
        $city->delete();
        return redirect()->route('cityindex')->with('success','city Has Been deleted successfully');;
    }
}
