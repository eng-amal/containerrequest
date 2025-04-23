<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nationality;
class nationalitycontroller extends Controller
{
    public function getnationalitys(Request $request)
    {
        // Fetch categories from the database
        $nationalitys = nationality::all();

        // Return data as JSON
        return response()->json($nationalitys);
    }
    public function nationalityindex()
    {
        $nationalitys = nationality::all();
            
            return view('nationalityindex', compact('nationalitys'));
    }
    public function createnationality()
    {
       
        return view('createnationality');
    }
    public function storenationality(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',

            ]);
       
        nationality::create($request->post());
        return redirect()->route('nationalityindex')->with('success','nationality has been created successfully.');
    }
    
    public function destroynationality($id)
    {
        $nationality = nationality::findOrFail($id);
        $nationality->delete();
        return redirect()->route('nationalityindex')->with('success','nationality Has Been deleted successfully');;
    }
}
