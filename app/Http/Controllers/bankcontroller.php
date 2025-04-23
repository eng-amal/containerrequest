<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bank;
class bankcontroller extends Controller
{
    public function getbanks(Request $request)
    {
        // Fetch categories from the database
        $banks = bank::all();

        // Return data as JSON
        return response()->json($banks);
    }
    public function bankindex()
    {
        $banks = bank::all();
            
            return view('bankindex', compact('banks'));
    }
    public function createbank()
    {
       
        return view('createbank');
    }
    public function storebank(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',

            ]);
       
        bank::create($request->post());
        return redirect()->route('bankindex')->with('success','bank has been created successfully.');
    }
    
    public function destroybank($id)
    {
        $bank = bank::findOrFail($id);
        $bank->delete();
        return redirect()->route('bankindex')->with('success','bank Has Been deleted successfully');;
    }
}
