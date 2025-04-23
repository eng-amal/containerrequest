<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\car;
class carcontroller extends Controller
{
    public function getcars(Request $request)
    {
        // Fetch categories from the database
        $cars = car::all();

        // Return data as JSON
        return response()->json($cars);
    }
    public function carindex()
    {
        $cars = car::all();
        $carexamins = carexamin::whereIn('carid', $cars->pluck('id'))->orderBy('todate', 'desc') 
        ->get()
        ->groupBy('carid')
        ->map(function ($res) {
            return $res->first(); // Get the latest record per employee
        });
        $operationcards = operationcard::whereIn('carid', $cars->pluck('id'))->orderBy('todate', 'desc') 
        ->get()
        ->groupBy('carid')
        ->map(function ($res) {
            return $res->first(); // Get the latest record per employee
        });   
            return view('carindex', compact('cars','carexamins','operationcards'));
    }
    public function createcar()
    {
       
        return view('createcar');
    }
    public function storecar(Request $request)
    {
    $request->validate([
                'model' => 'required',
                'no' => 'required',
                'empid'=>'nullable|digits_between:1,10',
            ]);
       
        car::create($request->post());
        return redirect()->route('carindex')->with('success','car has been created successfully.');
    }
    public function caredit($id)
    {
        $car = car::findOrFail($id);
        return view('caredit',compact('car'));
    }
    public function carupdate(Request $request,$id)
    {
        $car = car::findOrFail($id);
        $request->validate([
            'model' => 'required',
            'no' => 'required',
            'empid'=>'nullable|digits_between:1,10',
        ]);
        $car->fill($request->post())->save();
        
        return redirect()->route('carindex')->with('success','car Has Been updated successfully');
    }
    public function destroycar($id)
    {
        $car = car::findOrFail($id);
        $car->delete();
        return redirect()->route('carindex')->with('success','car Has Been deleted successfully');;
    }
}
