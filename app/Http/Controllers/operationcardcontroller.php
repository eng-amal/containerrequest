<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\operationcard;
use App\Models\car;
class operationcardcontroller extends Controller
{
    public function operationcardindex($id)
    {
            
            // Get the filtered and paginated results
            $operationcards = operationcard::where('carid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $car = car::findOrFail($id);
            return view('operationcardindex', compact('operationcards','car'));
    }
    public function createoperationcard($id)
    {
        $car = car::findOrFail($id);
        return view('createoperationcard',compact('car'));
    }
    public function storeoperationcard(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'idnumber' => 'required',
                'cardno' => 'required',
                'maker' => 'required',
                'model' => 'required',
                'patenumber' => 'required',
                'color' => 'required',
                'fromdate' => 'required|date',
                'todate' =>  'required||date|after_or_equal:fromdate',
                 'carid' => 'required|digits_between:1,10',
                 'modelyear' => 'required|digits_between:1,10',
                
            ]);
        $carid=$request->input('carid');
        operationcard::create($request->post());
        return redirect()->route('operationcardindex',$carid)->with('success','operationcard has been created successfully.');
    }
    
    public function destroyoperationcard($id)
    {
        $operationcard = operationcard::findOrFail($id);
        $carid=$operationcard->carid;
        $operationcard->delete();
        return redirect()->route('operationcardindex',$carid)->with('success','operationcard Has Been deleted successfully');;
    }
}
