<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\stay;
class staycontroller extends Controller
{
    public function stayindex($id)
    {
            
            // Get the filtered and paginated results
            $stays = stay::where('empid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $employee = employee::findOrFail($id);
            return view('stayindex', compact('stays','employee'));
    }
    public function createstay($id)
    {
        $employee = employee::findOrFail($id);
        return view('createstay',compact('employee'));
    }
    public function storestay(Request $request)
    {
        $request->validate([
                'staynum' => 'required|digits_between:1,10',
                'fromdate' => 'required|date',
                'todate' =>  'required||date|after_or_equal:fromdate',
                 'empid' => 'required|digits_between:1,10',
                
            ]);
        $empid=$request->input('empid');
        stay::create($request->post());
        return redirect()->route('stayindex',$empid)->with('success','stay has been created successfully.');
    }
    public function stayedit($id)
    {
        $stay = stay::findOrFail($id);
       
        return view('stayedit',compact('stay'));
    }
    public function stayupdate(Request $request,$id)
    {
        $stay = stay::findOrFail($id);
        $request->validate([
            'staynum' => 'required|digits_between:1,10',
            'fromdate' => 'required|date',
            'todate' =>  'required||date|after_or_equal:fromdate',
             'empid' => 'required|digits_between:1,10',
            
        ]);
        $stay->fill($request->post())->save();
        
        return redirect()->route('stayindex', $stay->empid)->with('success','stay Has Been updated successfully');
    }
    public function destroystay($id)
    {
        $stay = stay::findOrFail($id);
        $empid=$stay->empid;
        $stay->delete();
        return redirect()->route('stayindex',$empid)->with('success','stay Has Been deleted successfully');;
    }
}
