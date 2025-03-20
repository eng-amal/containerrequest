<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\vacation;
use Carbon\Carbon;
class vacationcontroller extends Controller
{
    public function vacationindex($id)
    {
            
            // Get the filtered and paginated results
            $vacations = vacation::where('empid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            $employee = employee::findOrFail($id);
            return view('vacationindex', compact('vacations','employee'));
    }
    public function createvacation($id)
    {
        $employee = employee::findOrFail($id);
        return view('createvacation',compact('employee'));
    }
    public function storevacation(Request $request)
    {
        $request->validate([
                'vactype' => 'required|digits_between:1,10',
                'vacdate' => 'required|date',
                'peroid' => 'required|digits_between:1,10',
                'empid' => 'required|digits_between:1,10',
                
            ]);
            $empid=$request->input('empid');
            $vactype=$request->input('vactype');
            $newperoid=$request->input('peroid');
            $employee = employee::findOrFail($empid);
            $vacnum=$employee->vacnum;
            if ($vactype == 1) {
        $vacationcount = vacation::where('empid', $empid)->count('id');
        if (($vacationcount + $newperoid) >$vacnum) {
            // If the sum exceeds the contract's total, show a message and redirect back
            return redirect()->back()->with('error', ' You cannot add more vacations.');
        }
       }
       // Calculate the vacation end date
    $startDate = Carbon::parse($request->vacdate);
    $endDate = $startDate->copy()->addDays($request->peroid - 1);

    // Check if there are overlapping vacations
    $existingVacation = vacation::where('empid', $empid)
    ->where(function ($query) use ($startDate, $endDate) {
        $query->whereBetween('vacdate', [$startDate, $endDate])
              ->orWhereRaw('? BETWEEN vacdate AND DATE_ADD(vacdate, INTERVAL (peroid - 1) DAY)', [$startDate])
              ->orWhereRaw('? BETWEEN vacdate AND DATE_ADD(vacdate, INTERVAL (peroid - 1) DAY)', [$endDate]);
    })->exists();

    if ($existingVacation) {
        return back()->withErrors(['vacdate' => 'This vacation peroid overlaps with an existing vacation.']);
    }
        vacation::create($request->post());
        return redirect()->route('vacationindex',$empid)->with('success','vacation has been created successfully.');
    }
    public function vacationedit($id)
    {
        $vacation = vacation::findOrFail($id);
       
        return view('vacationedit',compact('vacation'));
    }
    public function vacationupdate(Request $request,$id)
    {
        $vacation = vacation::findOrFail($id);
        $request->validate([
            'vactype' => 'required|digits_between:1,10',
            'vacdate' => 'required|date',
            'peroid' => 'nullable|digits_between:1,10',
            'empid' => 'required|digits_between:1,10',
            
        ]);
        $oldperoid = $vacation->peroid;
        $newperoid = $request->input('peroid');
        $empid = $request->input('empid');
        $vactype=$request->input('vactype');
        if ($vactype == 1) {
        if ($oldperoid != $newperoid) 
        {
            if($newperoid>$oldperoid)
            {
                $peroid=$newperoid-$oldperoid;
                $vacationcount = vacation::where('empid', $empid)->count('id');
                $employee = employee::findOrFail($empid);
                $vacnum=$employee->vacnum;
                if (($vacationcount + $peroid) >$vacnum) {
                  // If the sum exceeds the contract's total, show a message and redirect back
                    return redirect()->back()->with('error', ' You cannot add more vacations.');
                }
            }
        }
      }
      $startDate = Carbon::parse($request->vacdate);
    $endDate = $startDate->copy()->addDays($request->peroid - 1);
    $existingVacation = Vacation::where('empid', $empid)
        ->where('id', '!=', $id) // Exclude the current vacation being updated
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('vacdate', [$startDate, $endDate])
                  ->orWhereRaw('? BETWEEN vacdate AND DATE_ADD(vacdate, INTERVAL (peroid - 1) DAY)', [$startDate])
                  ->orWhereRaw('? BETWEEN vacdate AND DATE_ADD(vacdate, INTERVAL (peroid - 1) DAY)', [$endDate]);
        })
        ->exists();

    if ($existingVacation) {
        return back()->withErrors(['vacdate' => 'This vacation peroid overlaps with an existing vacation.']);
    }
        $vacation->fill($request->post())->save();
        
        return redirect()->route('vacationindex', $vacation->empid)->with('success','vacation Has Been updated successfully');
    }
    public function destroyvacation($id)
    {
        $vacation = vacation::findOrFail($id);
        $empid=$vacation->empid;
        $vacation->delete();
        return redirect()->route('vacationindex',$empid)->with('success','vacation Has Been deleted successfully');;
    }
}
