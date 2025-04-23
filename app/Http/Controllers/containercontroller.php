<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\container;
use App\Models\containersize;
class containercontroller extends Controller
{
    public function getcontainers(Request $request)
    {
        // Fetch categories from the database
        $firstSelectValue = $request->get('contsid');
        $options = container::where('status','=',0)->where('sizeid','=',$firstSelectValue)
        ->get(['id', 'no']);

        
        // Return the options as JSON
        return response()->json([
            'options' => $options
        ]);
    }
    public function getcontainers1(Request $request)
    {
        // Fetch categories from the database
        $firstSelectValue = $request->get('contsid');
        $options = container::where('sizeid','=',$firstSelectValue)
        ->get(['id', 'no']);

        
        // Return the options as JSON
        return response()->json([
            'options' => $options
        ]);
    }
    public function containerindex($id)
    {
            
            // Get the filtered and paginated results
            $containers = container::where('sizeid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $containersize = containersize::findOrFail($id);
            return view('containerindex', compact('containers','containersize'));
    }
    public function createcontainer($id)
    {
        $containersize = containersize::findOrFail($id);
        return view('createcontainer',compact('containersize'));
    }
    public function storecontainer(Request $request)
    {
        $request->validate([
                'no' => 'required',
                'sizeid' => 'required|digits_between:1,10',
                
            ]);
        $sizeid=$request->input('sizeid');
        container::create($request->post());
        return redirect()->route('containerindex',$sizeid)->with('success','container has been created successfully.');
    }
    public function destroycontainer($id)
    {
        $container = container::findOrFail($id);
        $sizeid=$container->sizeid;
        $container->delete();
        return redirect()->route('containerindex',$sizeid)->with('success','container Has Been deleted successfully');;
    }
}
