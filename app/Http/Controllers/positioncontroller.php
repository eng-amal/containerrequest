<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position;
class positioncontroller extends Controller
{

    public function getpositions(Request $request)
    {
        // Fetch categories from the database
        $positions = position::all();

        // Return data as JSON
        return response()->json($positions);
    }

    public function positionindex()
    {
    // Get the filtered and paginated results
            $positions = position::all(); // You can change 10 to the number of rows per page
        
            return view('positionindex', compact('positions'));
    }
    public function createposition()
    {
       
        return view('createposition');
    }
    public function storeposition(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',
            ]);
       
        position::create($request->post());
        return redirect()->route('positionindex')->with('success','position has been created successfully.');
    }
    public function positionedit($id)
    {
        $position = position::findOrFail($id);
        return view('positionedit',compact('position'));
    }
    public function positionupdate(Request $request,$id)
    {
        $position = position::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'enname' => 'required',
        ]);
        $position->fill($request->post())->save();
        
        return redirect()->route('positionindex')->with('success','position Has Been updated successfully');
    }
    public function destroyposition($id)
    {
        $position = position::findOrFail($id);
        $position->delete();
        return redirect()->route('positionindex')->with('success','position Has Been deleted successfully');;
    }
}
