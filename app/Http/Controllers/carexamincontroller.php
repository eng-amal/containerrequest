<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\carexamin;
use App\Models\car;
class carexamincontroller extends Controller
{
    public function carexaminindex($id)
    {
            
            // Get the filtered and paginated results
            $carexamins = carexamin::where('carid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $car = car::findOrFail($id);
            return view('carexaminindex', compact('carexamins','car'));
    }
    public function createcarexamin($id)
    {
        $car = car::findOrFail($id);
        return view('createcarexamin',compact('car'));
    }
    public function storecarexamin(Request $request)
    {
        $request->validate([
                'carexaminnum' => 'required|digits_between:1,10',
                'fromdate' => 'required|date',
                'todate' =>  'required||date|after_or_equal:fromdate',
                 'carid' => 'required|digits_between:1,10',
                
            ]);
        $carid=$request->input('carid');
        carexamin::create($request->post());
        return redirect()->route('carexaminindex',$carid)->with('success','carexamin has been created successfully.');
    }
    
    public function destroycarexamin($id)
    {
        $carexamin = carexamin::findOrFail($id);
        $carid=$carexamin->carid;
        $carexamin->delete();
        return redirect()->route('carexaminindex',$carid)->with('success','carexamin Has Been deleted successfully');;
    }
}
