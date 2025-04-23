<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\department;
use App\Models\position;
use App\Models\nationality;
use App\Models\stay;
use App\Models\drivercard;
use App\Models\decision;
use App\Models\addition;
use App\Models\vacation;
use App\Models\account;
class employeecontroller extends Controller
{
    public function getemployees(Request $request)
    {
        // Fetch categories from the database
        $employees = employee::all();

        // Return data as JSON
        return response()->json($employees);
    }
    public function getdrivers(Request $request)
    {
        $requestDate = $request->requestdate;

        // Subquery to get employee IDs who are on vacation on the request date
        $vacationingEmployees = DB::table('vacation')
            ->whereDate('vacdate', '<=', $requestDate)
            ->whereRaw("DATE_ADD(vacdate, INTERVAL peroid DAY) > ?", [$requestDate])
            ->pluck('empid');
    
        // Get employees with position_id = 1 who are NOT on vacation
        $employees = Employee::where('position_id', 1)
            ->whereNotIn('id', $vacationingEmployees)
            ->get();
    
        return response()->json($employees);
    }
    public function employeeindex(Request $request)
    {
    // Get the filtered and paginated results
           $query = employee::query();
           // Apply search filters if the search parameters are present
            if ($request->has('search_mobile') && $request->search_mobile != '') {
                $query->where('mobileno', 'like', '%' . $request->search_mobile . '%');
            }
        if ($request->has('search_cust_name') && $request->search_cust_name != '') {
                $query->where('custname', 'like', '%' . $request->search_cust_name . '%');
            }
            // Get the filtered and paginated results
            $employees = $query->orderBy('id','desc')->paginate(10);
            $stays = stay::whereIn('empid', $employees->pluck('id'))->orderBy('todate', 'desc') 
            ->get()
            ->groupBy('empid')
            ->map(function ($res) {
                return $res->first(); // Get the latest record per employee
            });
            $drivercards = drivercard::whereIn('empid', $employees->pluck('id'))->orderBy('todate', 'desc') 
            ->get()
            ->groupBy('empid')
            ->map(function ($res) {
                return $res->first(); // Get the latest record per employee
            });
    
            return view('employeeindex', compact('employees','stays','drivercards'));
    }
    public function createemployee()
    {
       
        return view('createemployee');
    }
    public function storeemployee(Request $request)
    {
    $request->validate([
                'fullname' => 'required',
                'nationality' => 'required',
                'birthdate' => 'required|date',
                'hiredate' => 'required|date',
                'department_id' => 'required',
                'position_id' => 'required',
                'address' => 'required',
                'mobileno' => 'required',
                'enfullname' => 'required',
                'mainsal' => 'required',
                'empimg'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'employeeid'=> 'required',
                'accountid' => 'required|digits_between:1,10',
            ]);
            $imagePath = null;
            if ($request->hasFile('empimg')) {
                // Store the image in the 'public' directory
                $imagePath = $request->file('empimg')->store('transfer_images', 'public');
                $request->merge(['empimg' => $imagePath]);
            }
        employee::create($request->post());
        return redirect()->route('employeeindex')->with('success','employee has been created successfully.');
    }
    public function employeeedit($id)
    {
        $departments = department::all();
        $positions = position::all();
        $nationalitys = nationality::all();
        $accounts = account::all();
        $employee = employee::findOrFail($id);
        return view('employeeedit',compact('employee','accounts','departments','positions','nationalitys'));
    }
    public function employeeupdate(Request $request,$id)
    {
        $employee = employee::findOrFail($id);
        $request->validate([
            'fullname' => 'required',
            'nationality' => 'required',
            'birthdate' => 'required|date',
            'hiredate' => 'required|date',
            'department_id' => 'required',
            'position_id' => 'required',
            'address' => 'required',
            'mobileno' => 'required',
            'enfullname' => 'required',
            'mainsal' => 'required',
            'empimg'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'employeeid'=> 'required',
            'accountid' => 'required|digits_between:1,10',
        ]);
        $imagePath = null;
            if ($request->hasFile('empimg')) {
                // Store the image in the 'public' directory
                $imagePath = $request->file('empimg')->store('transfer_images', 'public');
                $request->merge(['empimg' => $imagePath]);
            }
        $employee->fill($request->post())->save();
        
        return redirect()->route('employeeindex')->with('success','employee Has Been updated successfully');
    }
    public function destroyemployee($id)
    {
        $employee = employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employeeindex')->with('success','employee Has Been deleted successfully');;
    }

    public function calculateSalaries(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m')); // Default to current month

    // Convert to start and end of the month
    $startOfMonth = Carbon::parse($selectedMonth)->startOfMonth();
    $endOfMonth = Carbon::parse($selectedMonth)->endOfMonth();

    $employees = Employee::all();
    $workingDays = 26; // Assuming 26 working days in a month

    $salaries = $employees->map(function ($employee) use ($startOfMonth, $endOfMonth, $workingDays) {
        $basicSalary = $employee->mainsal;
        $dailySalary = $basicSalary / $workingDays;

        // Calculate unpaid leave days properly (considering cross-month leaves)
        $unpaidLeaveDays = vacation::where('empid', $employee->id)
    ->where('vactype', '=', 3)
    ->where(function ($query) use ($startOfMonth, $endOfMonth) {
        $query->where(function ($q) use ($startOfMonth, $endOfMonth) {
            // Leave fully within the month
            $q->whereBetween('vacdate', [$startOfMonth, $endOfMonth]);
        })
        ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
            // Leave starts before the month and ends within or after the month
            $q->where('vacdate', '<', $startOfMonth)
              ->whereRaw('DATE_ADD(vacdate, INTERVAL peroid DAY) > ?', [$startOfMonth]);
        });
    })
    ->get()
    ->sum(function ($leave) use ($startOfMonth, $endOfMonth) {
        $leaveStart = Carbon::parse($leave->vacdate);
        $leaveEnd = $leaveStart->copy()->addDays($leave->peroid - 1);

        // If leave started before the month, adjust start date
        if ($leaveStart < $startOfMonth) {
            $leaveStart = $startOfMonth;
        }

        // If leave ends after the month, adjust end date
        if ($leaveEnd > $endOfMonth) {
            $leaveEnd = $endOfMonth;
        }

        return $leaveStart->diffInDays($leaveEnd) + 1; // +1 to include the last day
    });

        $unpaidDeduction = $unpaidLeaveDays * $dailySalary;

        // Calculate health leave deduction (20% per day)
        $healthLeaveDays = vacation::where('empid', $employee->id)
    ->where('vactype', '=', 2)
    ->where(function ($query) use ($startOfMonth, $endOfMonth) {
        $query->where(function ($q) use ($startOfMonth, $endOfMonth) {
            // Leave fully within the month
            $q->whereBetween('vacdate', [$startOfMonth, $endOfMonth]);
        })
        ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
            // Leave starts before the month and ends within or after the month
            $q->where('vacdate', '<', $startOfMonth)
              ->whereRaw('DATE_ADD(vacdate, INTERVAL peroid DAY) > ?', [$startOfMonth]);
        });
    })
    ->get()
    ->sum(function ($leave) use ($startOfMonth, $endOfMonth) {
        $leaveStart = Carbon::parse($leave->vacdate);
        $leaveEnd = $leaveStart->copy()->addDays($leave->peroid - 1);

        // If leave started before the month, adjust start date
        if ($leaveStart < $startOfMonth) {
            $leaveStart = $startOfMonth;
        }

        // If leave ends after the month, adjust end date
        if ($leaveEnd > $endOfMonth) {
            $leaveEnd = $endOfMonth;
        }

        return $leaveStart->diffInDays($leaveEnd) + 1; // +1 to include the last day
    });

        $healthDeduction = round($healthLeaveDays * ($dailySalary * 0.2), 2);

        // Net salary after leave deductions
        $netSalary = $basicSalary - ($unpaidDeduction + $healthDeduction);

        // Apply compensation
        $compensations = addition::where('empid', $employee->id)
            ->where('isadd','=', 1)
            ->get();

        foreach ($compensations as $comp) {
            if ($comp->ispercent == 1) {
                $netSalary += $comp->amount;
            } elseif ($comp->ispercent == 2) {
                $netSalary += ($basicSalary * $comp->amount / 100);
            }
        }

        // Apply deductions
        $deductions = addition::where('empid', $employee->id)
        ->where('isadd','=', 2)
            ->get();

        foreach ($deductions as $deduction) {
            if ($deduction->ispercent == 1) {
                $netSalary -= $deduction->amount;
            } elseif ($deduction->ispercent == 2) {
                $netSalary -= ($basicSalary * $deduction->amount / 100);
            }
        }

        // Apply penalties
        $penalties = decision::where('empid', $employee->id)
            ->whereMonth('decisiondate', $startOfMonth->month)
            ->whereYear('decisiondate', $startOfMonth->year)
            ->sum('amount');

        $netSalary -= $penalties;

        return [
            'name' => $employee->fullname,
            'basic_salary' => $basicSalary,
            'unpaid_leave_days' => $unpaidLeaveDays,
            'unpaid_deduction' => $unpaidDeduction,
            'health_leave_days' => $healthLeaveDays,
            'health_deduction' => $healthDeduction,
            'net_salary' => $netSalary
        ];
    });

    return view('salaryindex', compact('salaries', 'selectedMonth'));
    }
    public function salaryindex()
    {
        return view('salaryindex');
    }

}
