<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\street;
use App\Models\city;
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
    public function streetindex($id)
    {
            
            // Get the filtered and paginated results
            $streets = street::where('cityid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $city = city::findOrFail($id);
            return view('streetindex', compact('streets','city'));
    }
    public function createstreet($id)
    {
        $city = city::findOrFail($id);
        return view('createstreet',compact('city'));
    }
    public function storestreet(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'enname' => 'required',
                'cityid' => 'required|digits_between:1,10',
                
            ]);
        $cityid=$request->input('cityid');
        street::create($request->post());
        return redirect()->route('streetindex',$cityid)->with('success','street has been created successfully.');
    }
    public function destroystreet($id)
    {
        $street = street::findOrFail($id);
        $cityid=$street->cityid;
        $street->delete();
        return redirect()->route('streetindex',$cityid)->with('success','street Has Been deleted successfully');;
    }
}
