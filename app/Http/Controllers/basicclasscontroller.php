<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\basicclass;
class basicclasscontroller extends Controller
{
    public function getbasicclasss(Request $request)
    {
        // Fetch categories from the database
        $basicclasss = basicclass::all();

        // Return data as JSON
        return response()->json($basicclasss);
    }
    public function basicclassindex()
    {
        $basicclasss = basicclass::all();
            
            return view('basicclassindex', compact('basicclasss'));
    }
    public function createbasicclass()
    {
       
        return view('createbasicclass');
    }
    public function storebasicclass(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',

            ]);
       
        basicclass::create($request->post());
        return redirect()->route('basicclassindex')->with('success','basicclass has been created successfully.');
    }
    
    public function destroybasicclass($id)
    {
        $basicclass = basicclass::findOrFail($id);
        $basicclass->delete();
        return redirect()->route('basicclassindex')->with('success','basicclass Has Been deleted successfully');;
    }
}
