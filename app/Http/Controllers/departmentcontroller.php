<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
class departmentcontroller extends Controller
{
    public function getdepartments(Request $request)
    {
        // Fetch categories from the database
        $departments = department::all();

        // Return data as JSON
        return response()->json($departments);
    }
    public function departmentindex()
    {
        $departments = department::all();
            
            return view('departmentindex', compact('departments'));
    }
    public function createdepartment()
    {
       
        return view('createdepartment');
    }
    public function storedepartment(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',
            ]);
       
        department::create($request->post());
        return redirect()->route('departmentindex')->with('success','department has been created successfully.');
    }
    public function departmentedit($id)
    {
        $department = department::findOrFail($id);
        return view('departmentedit',compact('department'));
    }
    public function departmentupdate(Request $request,$id)
    {
        $department = department::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'enname' => 'required',
        ]);
        $department->fill($request->post())->save();
        
        return redirect()->route('departmentindex')->with('success','department Has Been updated successfully');
    }
    public function destroydepartment($id)
    {
        $department = department::findOrFail($id);
        $department->delete();
        return redirect()->route('departmentindex')->with('success','department Has Been deleted successfully');;
    }
}
