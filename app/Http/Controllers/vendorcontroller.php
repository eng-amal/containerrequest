<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vendor;
use App\Models\city;
use App\Models\street;
use App\Models\account;
class vendorcontroller extends Controller
{
    public function getvendors(Request $request)
    {
        // Fetch categories from the database
        $vendors = vendor::all();

        // Return data as JSON
        return response()->json($vendors);
    }
    public function vendorindex()
    {
        $vendors = vendor::all();
            
            return view('vendorindex', compact('vendors'));
    }
    public function createvendor()
    {
       
        return view('createvendor');
    }
    public function storevendor(Request $request)
    {
    $request->validate([
                'fullname' => 'required',
                'mobno' => 'required',
                'email' => 'required',
                'address' => 'required',
                'cityid' => 'required',
                'streetid' => 'required',
                'detail' => 'required',
                'accountid' => 'required',
            ]);
       
        vendor::create($request->post());
        return redirect()->route('vendorindex')->with('success','vendor has been created successfully.');
    }
    public function vendoredit($id)
    {
        $vendor = vendor::findOrFail($id);
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $vendor->cityid)->get();
        $accounts = account::all();
        return view('vendoredit',compact('vendor','citys','streets','accounts'));
    }
    public function vendorupdate(Request $request,$id)
    {
        $vendor = vendor::findOrFail($id);
        $request->validate([
            'fullname' => 'required',
                'mobno' => 'required',
                'email' => 'required',
                'address' => 'required',
                'cityid' => 'required',
                'streetid' => 'required',
                'detail' => 'required',
                'accountid' => 'required',
        ]);
        $vendor->fill($request->post())->save();
        
        return redirect()->route('vendorindex')->with('success','vendor Has Been updated successfully');
    }
    public function destroyvendor($id)
    {
        $vendor = vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->route('vendorindex')->with('success','vendor Has Been deleted successfully');;
    }
}
