<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\drivercard;
use App\Models\employee;
class drivercardcontroller extends Controller
{
    public function drivercardindex($id)
    {
            
            // Get the filtered and paginated results
            $drivercards = drivercard::where('empid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $employee=employee::findOrFail($id);
            return view('drivercardindex', compact('drivercards','car'));
    }
    public function createdrivercard($id)
    {
        $employee=employee::findOrFail($id);
        return view('createdrivercard',compact('car'));
    }
    public function storedrivercard(Request $request)
    {
        $request->validate([
                'cardno' => 'required',
                'driverno'=> 'required',
                
                'fromdate' => 'required|date',
                'todate' =>  'required||date|after_or_equal:fromdate',
                'category'=> 'required|digits_between:1,10',
                'moinumber'=> 'required',
                'moiname'=> 'required',
                 'empid' => 'required|digits_between:1,10',
                
            ]);
        $empid=$request->input('empid');
        $emp = employee::find($empid);
    $fullname=$emp->fullname;
    $employeeid=$emp->employeeid;
    $request->merge(['drivername' => $fullname]);
    $request->merge(['driverid' => $employeeid]);
        drivercard::create($request->post());
        return redirect()->route('drivercardindex',$empid)->with('success','drivercard has been created successfully.');
    }
    
    public function destroydrivercard($id)
    {
        $drivercard = drivercard::findOrFail($id);
        $empid=$drivercard->empid;
        $drivercard->delete();
        return redirect()->route('drivercardindex',$empid)->with('success','drivercard Has Been deleted successfully');;
    }
}
