<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sand;
use App\Models\account;
use Illuminate\Support\Facades\DB;
class sandcontroller extends Controller
{
    public function sandSearch(Request $request)
{
    // جلب الحسابات لقائمة الاختيار
    $accounts = DB::table('account')->select('id', 'name')->get();

    // استعلام السندات
    $query = DB::table('sand as s')
        ->leftJoin('account as sa', 's.saccountid', '=', 'sa.id')
        ->leftJoin('account as ra', 's.raccountid', '=', 'ra.id')
        ->select(
            's.id',               // رقم السند
            's.sanddate',         // تاريخ السند
            's.amount',           // المبلغ الإجمالي
            's.type',             // نوع السند
            DB::raw('
                CASE 
                    WHEN s.type = 1 THEN "سند قبض"
                    WHEN s.type = 2 THEN "سند دفع"
                    WHEN s.type = 3 THEN "سند حوالة بنكية"
                    ELSE "غير معروف"
                END as type_label
            '),
            // مبلغ المدين بناءً على الشروط
            DB::raw('
                CASE
                    WHEN s.type IN (1, 3) AND s.raccountid = ' . intval($request->account_id) . ' THEN s.amount
                    WHEN s.type = 2 AND s.saccountid = ' . intval($request->account_id) . ' THEN s.amount
                    ELSE 0
                END as debit_amount
            '),
            // مبلغ الدائن بناءً على الشروط
            DB::raw('
                CASE
                    WHEN s.type IN (1, 3) AND s.saccountid = ' . intval($request->account_id) . ' THEN s.amount
                    WHEN s.type = 2 AND s.raccountid = ' . intval($request->account_id) . ' THEN s.amount
                    ELSE 0
                END as credit_amount
            ')
        );

    // فلترة الحساب إذا تم اختياره
    if ($request->filled('account_id')) {
        $query->where(function($q) use ($request) {
            $q->where('s.saccountid', $request->account_id)
              ->orWhere('s.raccountid', $request->account_id);
        });
    }

    // فلترة بالتاريخ "من تاريخ"
    if ($request->filled('from_date')) {
        $query->whereDate('s.sanddate', '>=', $request->from_date);
    }

    // فلترة بالتاريخ "إلى تاريخ"
    if ($request->filled('to_date')) {
        $query->whereDate('s.sanddate', '<=', $request->to_date);
    }

    // ترتيب النتائج حسب التاريخ تنازلياً
    $sands = $query->orderBy('s.sanddate', 'desc')->get();

    // إرجاع النتائج مع الحسابات إلى واجهة العرض
    return view('sandsearch', compact('accounts', 'sands'));
}


    public function createsand()
    {
       
        return view('createsand');
    }
    public function storesand(Request $request)
    {
    $request->validate([
                'sanddate' => 'required|date',
                'saccountid' => 'required',
                'raccountid' => 'required',
                'amount' => 'required',
                'type' => 'required',
            ]);
//from account
            $saccountid = $request->input('saccountid'); // Add a field for car_id in your form
            $saccount = account::find($saccountid);
            if ($saccount) {
                $saccount->outamount =$saccount->outamount+$request->input('amount');
                $saccount->balance =$saccount->inamount-$saccount->outamount;
                $saccount->save();
            }
            //to account
            $raccountid = $request->input('raccountid'); // Add a field for car_id in your form
            $raccount = account::find($raccountid);
            if ($raccount) {
                $raccount->inamount =$raccount->inamount+$request->input('amount');
                $raccount->balance =$raccount->inamount-$raccount->outamount;
                $raccount->save();
            }
        sand::create($request->post());
        return redirect()->route('createsand')->with('success','sand has been created successfully.');
    }
}
