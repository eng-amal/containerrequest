<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\addition;
class additioncontroller extends Controller
{
    public function additionindex($id)
    {
            
            // Get the filtered and paginated results
            $additions = addition::where('empid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $employee = employee::findOrFail($id);
            return view('additionindex', compact('additions','employee'));
    }
    public function createaddition($id)
    {
        $employee = employee::findOrFail($id);
        return view('createaddition',compact('employee'));
    }
    public function storeaddition(Request $request)
    {
        $request->validate([
                'additiontype' => 'required|digits_between:1,10',
                'isadd' => 'required|digits_between:1,10',
                'empid' => 'required|digits_between:1,10',
                'amount' => 'required|digits_between:1,10',
                'ispercent' => 'required|digits_between:1,10',
                
            ]);
        $empid=$request->input('empid');
        addition::create($request->post());
        return redirect()->route('additionindex',$empid)->with('success','addition has been created successfully.');
    }
    public function additionedit($id)
    {
        $addition = addition::findOrFail($id);
       
        return view('additionedit',compact('addition'));
    }
    public function additionupdate(Request $request,$id)
    {
        $addition = addition::findOrFail($id);
        $request->validate([
            'additiontype' => 'required|digits_between:1,10',
            'isadd' => 'required|digits_between:1,10',
            'empid' => 'required|digits_between:1,10',
            'amount' => 'required|digits_between:1,10',
            'ispercent' => 'required|digits_between:1,10',
            
        ]);
        
        $addition->fill($request->post())->save();
        
        return redirect()->route('additionindex', $addition->empid)->with('success','addition Has Been updated successfully');
    }
    public function destroyaddition($id)
    {
        $addition = addition::findOrFail($id);
        $empid=$addition->empid;
        $addition->delete();
        return redirect()->route('additionindex',$empid)->with('success','addition Has Been deleted successfully');;
    }
}
