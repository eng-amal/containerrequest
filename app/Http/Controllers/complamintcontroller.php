<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\complamint;
use App\Models\complamintreason;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class complamintcontroller extends Controller
{
    
public function complamintindex(Request $request)
    {
        $statusLabels = [
        1 => __('contreq.comstatusid1'),
        2 => __('contreq.comstatusid2'),
        3 => __('contreq.comstatusid3'),
    ];
    
    // Get the filtered and paginated results
            $query = DB::table('complamint as c')
            ->leftJoin('complamintreason as cr', 'c.comreasonid', '=', 'cr.id')
            ->leftJoin('containerrequest as r', 'c.reqid', '=', 'r.id')
            ->select(
                'c.id',               // رقم السند
                'c.comdate',         // تاريخ السند
                'c.descr',           // المبلغ الإجمالي
                'c.comstatusid' ,        // نوع السند
                DB::raw("
    CASE 
        WHEN c.comstatusid = 1 THEN '".__('contreq.comstatusid1')."'
        WHEN c.comstatusid = 2 THEN '".__('contreq.comstatusid2')."'
        WHEN c.comstatusid = 3 THEN '".__('contreq.comstatusid3')."'
        ELSE '-'
    END as type_label
"),
            'r.custname', 
            'cr.name',
            );
            if ($request->filled('from_date')) {
                $query->whereDate('c.comdate', '>=', $request->from_date);
            }
        
            // فلترة بالتاريخ "إلى تاريخ"
            if ($request->filled('to_date')) {
                $query->whereDate('c.comdate', '<=', $request->to_date);
            }
        
            // ترتيب النتائج حسب التاريخ تنازلياً
            $complamints = $query->orderBy('c.comdate', 'desc')->get();
            return view('complamintindex', compact('complamints'));
    }
    public function createcomplamint()
    {
       
        return view('createcomplamint');
    }
    public function storecomplamint(Request $request)
    {
    $request->validate([
                'reqid' => 'required',
                'comstatusid' => 'required',
                'comreasonid' =>'required',
                'descr' =>'required'
            ]);
       
        complamint::create($request->post());
        return redirect()->route('complamintindex')->with('success','complamint has been created successfully.');
    }
    public function complamintedit($id)
    {
        $complamint = complamint::findOrFail($id);
        $comreasonids= complamintreason::all();
        return view('complamintedit',compact('complamint','comreasonids'));
    }
    public function complamintupdate(Request $request,$id)
    {
        $complamint = complamint::findOrFail($id);
        $request->validate([
                'comstatusid' => 'required',
                'descr' =>'required'
        ]);
        $complamint->fill($request->post())->save();
        
        return redirect()->route('complamintindex')->with('success','complamint Has Been updated successfully');
    }
    public function destroycomplamint($id)
    {
        $complamint = complamint::findOrFail($id);
        $complamint->delete();
        return redirect()->route('complamintindex')->with('success','complamint Has Been deleted successfully');;
    }

}
