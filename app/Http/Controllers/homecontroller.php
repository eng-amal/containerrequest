<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\container;
use App\Models\stay;
use Illuminate\Support\Facades\DB;
class homecontroller extends Controller
{
    public function home()
{
    $today = Carbon::today()->toDateString();

    // Count by container status
    $availableCount = Container::where('status', 0)->count();
    $rentedCount = Container::where('status', 1)->count();
    $fullCount = Container::where('status', 3)->count();
    $leftCount = Container::where('status', 4)->count();
    $notEmptyCount = Container::where('status', 5)->count();

    // For status = 1, get containers with a valid current request (toDate >= today)
    $activeRentalCount = Container::where('status', 1)
        ->whereHas('latestRequest', function ($query) use ($today) {
            $query->whereDate('todate', '>=', $today);
        })->count();

        $today = Carbon::today();
        $nextMonth = $today->copy()->addMonth();
    
        // Subquery: Get latest 'stay' per employee (max todate)
        $latestStays = DB::table('stay as s1')
            ->select('s1.empid', 's1.todate')
            ->whereRaw('s1.todate = (SELECT MAX(s2.todate) FROM stay s2 WHERE s2.empid = s1.empid)')
            ->groupBy('s1.empid', 's1.todate');
    
        // Filter: Only stays that will expire within the next month
        $expiringCount = DB::table(DB::raw("({$latestStays->toSql()}) as latest"))
            ->mergeBindings($latestStays) // Important to keep bindings
            ->whereBetween('latest.todate', [$today, $nextMonth])
            ->count();
            $expiringCount1 = DB::table(DB::raw("({$latestStays->toSql()}) as latest"))
            ->mergeBindings($latestStays) // Important to keep bindings
            ->where('latest.todate','>=', $today)
            ->count();
    //drivercard
    // Subquery: Get latest 'drivercard' per employee (max todate)
    $latestcards = DB::table('drivercard as s1')
    ->select('s1.empid', 's1.todate')
    ->whereRaw('s1.todate = (SELECT MAX(s2.todate) FROM drivercard s2 WHERE s2.empid = s1.empid)')
    ->groupBy('s1.empid', 's1.todate');

// Filter: Only stays that will expire within the next month
$expiringdCount = DB::table(DB::raw("({$latestcards->toSql()}) as latest"))
    ->mergeBindings($latestcards) // Important to keep bindings
    ->whereBetween('latest.todate', [$today, $nextMonth])
    ->count();
    $expiringdCount1 = DB::table(DB::raw("({$latestcards->toSql()}) as latest"))
    ->mergeBindings($latestcards) // Important to keep bindings
    ->where('latest.todate','>=', $today)
    ->count();
//carexamin
    // Subquery: Get latest 'carexamin' per employee (max todate)
    $latestexamincards = DB::table('carexamin as s1')
    ->select('s1.carid', 's1.todate')
    ->whereRaw('s1.todate = (SELECT MAX(s2.todate) FROM carexamin s2 WHERE s2.carid = s1.carid)')
    ->groupBy('s1.carid', 's1.todate');

// Filter: Only stays that will expire within the next month
$expiringeCount = DB::table(DB::raw("({$latestexamincards->toSql()}) as latest"))
    ->mergeBindings($latestexamincards) // Important to keep bindings
    ->whereBetween('latest.todate', [$today, $nextMonth])
    ->count();
    $expiringeCount1 = DB::table(DB::raw("({$latestexamincards->toSql()}) as latest"))
    ->mergeBindings($latestexamincards) // Important to keep bindings
    ->where('latest.todate','>=', $today)
    ->count();


    return view('home', compact(
        'availableCount', 'rentedCount', 'fullCount',
        'leftCount', 'notEmptyCount', 'activeRentalCount','expiringCount','expiringCount1',
        'expiringdCount','expiringdCount1','expiringeCount','expiringeCount1'
    ));
 
        
	
}
}
