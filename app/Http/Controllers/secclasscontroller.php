<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\secclass;
use App\Models\basicclass;
class secclasscontroller extends Controller
{
    public function getsecclasss(Request $request)
    {
        $firstSelectValue = $request->get('parentid');

        // Query based on the first dropdown value
        // Replace this with your actual model logic
        $options = secclass::where('parentid', $firstSelectValue)
                                     ->get(['id', 'name']);
        
        // Return the options as JSON
        return response()->json([
            'options' => $options
        ]);
    }
    public function secclassindex($id)
    {
            
            // Get the filtered and paginated results
            $secclasss = secclass::where('parentid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $basicclass = basicclass::findOrFail($id);
            return view('secclassindex', compact('secclasss','basicclass'));
    }
    public function createsecclass($id)
    {
        $basicclass = basicclass::findOrFail($id);
        return view('createsecclass',compact('basicclass'));
    }
    public function storesecclass(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'enname' => 'required',
                'parentid' => 'required|digits_between:1,10',
                'minimum'=>'required',
                
            ]);
        $parentid=$request->input('parentid');
        secclass::create($request->post());
        return redirect()->route('secclassindex',$parentid)->with('success','secclass has been created successfully.');
    }
    public function destroysecclass($id)
    {
        $secclass = secclass::findOrFail($id);
        $parentid=$secclass->parentid;
        $secclass->delete();
        return redirect()->route('secclassindex',$parentid)->with('success','secclass Has Been deleted successfully');;
    }
}
