<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\complamintreason;
class complamintreasoncontroller extends Controller
{
    public function getcomplamintreasons(Request $request)
    {
        // Fetch categories from the database
        $complamintreasons = complamintreason::all();

        // Return data as JSON
        return response()->json($complamintreasons);
    }
    public function complamintreasonindex()
    {
        $complamintreasons = complamintreason::all();
            
            return view('complamintreasonindex', compact('complamintreasons'));
    }
    public function createcomplamintreason()
    {
       
        return view('createcomplamintreason');
    }
    public function storecomplamintreason(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',
            ]);
       
        complamintreason::create($request->post());
        return redirect()->route('complamintreasonindex')->with('success','complamintreason has been created successfully.');
    }
    
    public function destroycomplamintreason($id)
    {
        $complamintreason = complamintreason::findOrFail($id);
        $complamintreason->delete();
        return redirect()->route('complamintreasonindex')->with('success','complamintreason Has Been deleted successfully');;
    }
}
