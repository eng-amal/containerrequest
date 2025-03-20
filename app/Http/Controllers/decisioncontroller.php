<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\decision;
class decisioncontroller extends Controller
{
    public function decisionindex($id)
    {
            
            // Get the filtered and paginated results
            $decisions = decision::where('empid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $employee = employee::findOrFail($id);
            return view('decisionindex', compact('decisions','employee'));
    }
    public function createdecision($id)
    {
        $employee = employee::findOrFail($id);
        return view('createdecision',compact('employee'));
    }
    public function storedecision(Request $request)
    {
        $request->validate([
                'decisiontype' => 'required|digits_between:1,10',
                'decisiondate' => 'required|date',
                'decisionimg' =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'amount' => 'nullable|digits_between:1,10',
                'peroid' => 'nullable|digits_between:1,10',
                'empid' => 'required|digits_between:1,10',
                
            ]);
            $empid=$request->input('empid');
            $imagePath = null;
    if ($request->hasFile('decisionimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('decisionimg')->store('transfer_images', 'public');
        $request->merge(['decisionimg' => $imagePath]);
    }
        decision::create($request->post());
        return redirect()->route('decisionindex',$empid)->with('success','decision has been created successfully.');
    }
    public function decisionedit($id)
    {
        $decision = decision::findOrFail($id);
       
        return view('decisionedit',compact('decision'));
    }
    public function decisionupdate(Request $request,$id)
    {
        $decision = decision::findOrFail($id);
        $request->validate([
            'decisiontype' => 'required|digits_between:1,10',
            'decisiondate' => 'required|date',
            'decisionimg' =>  'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'amount' => 'nullable|digits_between:1,10',
            'peroid' => 'nullable|digits_between:1,10',
            'empid' => 'required|digits_between:1,10',
            
        ]);
        $imagePath = null;
    if ($request->hasFile('decisionimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('decisionimg')->store('transfer_images', 'public');
        $request->merge(['decisionimg' => $imagePath]);
    }
        $decision->fill($request->post())->save();
        
        return redirect()->route('decisionindex', $decision->empid)->with('success','decision Has Been updated successfully');
    }
    public function destroydecision($id)
    {
        $decision = decision::findOrFail($id);
        $empid=$decision->empid;
        $decision->delete();
        return redirect()->route('decisionindex',$empid)->with('success','decision Has Been deleted successfully');;
    }
}
