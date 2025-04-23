<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\containersize;
class containersizeController extends Controller
{
    public function getcontainersizes(Request $request)
    {
        // Fetch categories from the database
        $containersizes = containersize::all();

        // Return data as JSON
        return response()->json($containersizes);
    }

    public function containersizeindex()
    {
        $containersizes = containersize::all();
            
            return view('containersizeindex', compact('containersizes'));
    }
    public function createcontainersize()
    {
       
        return view('createcontainersize');
    }
    public function storecontainersize(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',

            ]);
       
        containersize::create($request->post());
        return redirect()->route('containersizeindex')->with('success','containersize has been created successfully.');
    }
    
    public function destroycontainersize($id)
    {
        $containersize = containersize::findOrFail($id);
        $containersize->delete();
        return redirect()->route('containersizeindex')->with('success','containersize Has Been deleted successfully');;
    }
}
