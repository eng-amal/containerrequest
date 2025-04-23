<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sand;
use App\Models\account;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TCPDF;
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
                'reason' =>'nullable',
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
    public function showsandReport(Request $request)
    {
        // التحقق من صحة التاريخ المدخل
        $request->validate([
            'fdate' =>'required|date',
            'tdate' => 'required|date',
        ]);

        // استلام التاريخ المدخل
        $fdate = Carbon::parse($request->input('fdate'))->format('Y-m-d');
        $tdate = Carbon::parse($request->input('tdate'))->format('Y-m-d');

        // استعلام البيانات بناءً على تاريخ fromdate
        $salesData = sand::whereDate('sand.sanddate', '>=', $fdate)
        ->whereDate('sand.sanddate', '<=', $tdate)// العقد يبدأ قبل أو عند tdate
        ->leftJoin('account as sa', 'sand.saccountid', '=', 'sa.id')
        ->leftJoin('account as ra', 'sand.raccountid', '=', 'ra.id')
        ->select(
            'sand.id',               // رقم السند
            'sand.sanddate',         // تاريخ السند
            'sand.amount',           // المبلغ الإجمالي
            'sand.type',
            'sand.reason',             // نوع السند
            DB::raw('
                CASE 
                    WHEN sand.type = 1 THEN "سند قبض"
                    WHEN sand.type = 2 THEN "سند دفع"
                    WHEN sand.type = 3 THEN "سند حوالة بنكية"
                    ELSE "غير معروف"
                END as type_label
            '),
            'sa.name as faccount',
            'ra.name as taccount'
            )
            ->get();

        // إرسال البيانات إلى دالة توليد التقرير
        $this->generatePDFsandReport($salesData,$fdate,$tdate);
    }

    public function generatePDFsandReport($salesData,$fdate,$tdate)
    {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير السندات ');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();

        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير السندات  من تاريخ  - ' .$fdate .' الى '. $tdate, 0, 1, 'C');

        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى

        // جدول المبيعات
        $pdf->Cell(30, 10, 'رقم السند', 1, 0, 'C');
        $pdf->Cell(30, 10, 'تاريخ السند', 1, 0, 'C');
        $pdf->Cell(30, 10, ' المبلغ', 1, 0, 'C');
        $pdf->Cell(30, 10, 'النوع', 1, 0, 'C');
        $pdf->Cell(30, 10, 'السبب', 1, 0, 'C');
        $pdf->Cell(40, 10, 'من حساب', 1, 0, 'C');
        $pdf->Cell(40, 10, ' الى حساب', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 9);
        // إضافة البيانات إلى الجدول
        
        foreach ($salesData as $data) {
            $pdf->Cell(30, 10, $data->id, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->sanddate, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->amount, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->type_label, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->reason, 1, 0, 'C');
            $pdf->Cell(40, 10, $data->faccount, 1, 0, 'C');
            $pdf->Cell(40, 10, $data->taccount, 1, 1, 'C');
     
        }
                // إخراج التقرير
        $pdf->Output('sands_report.pdf', 'I');
    }
    
    public function createsandssreport()
    {
            return view('createsandssreport');
            
        
    }
    public function generatesand(Request $request)
    {
        $type = $request->type;
        $saccountid = $request->saccountid;
        $date = $request->sanddate ?? date('Y-m-d');
    
        $account = \DB::table('account')->find($saccountid);
        $accountName = $account ? $account->name : '---';
        $title = $type == 1 ? 'إيصال قبض' : 'إيصال دفع';
        $lastId = \DB::table('sand')->max('id');
        $orderNumber = $lastId ? $lastId + 1 : 1;
        $amount = $request->amount ?? '---';
    
        // إعداد TCPDF
        $pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
        $pdf->setRTL(true);
        $pdf->SetCreator('Laravel');
        $pdf->SetTitle($title);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);
    
        // إعداد الخط العربي
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('freeserif', '', 16, '', true); // تأكد من توفر الخط aealarabiya
        $pdf->AddPage();
    
        // HTML محتوى التقرير
        $html = <<<EOD
    <div style="text-align: center;">
        <h2>$title</h2>
    </div>
    
    <table cellspacing="0" cellpadding="4" dir="rtl" style="width: 100%; font-size: 14px;">
        <tr>
            <td><strong>رقم الأمر:</strong> $orderNumber</td>
            <td><strong>المبلغ:</strong> $amount</td>
            <td><strong>التاريخ:</strong> $date</td>
        </tr>
    </table>
    
    <br><br>
    
    <div style="text-align: center;">
        <strong>السيد / $accountName</strong>
    </div>
    
    <br>
    
    <div dir="rtl" style="font-size: 14px; line-height: 1.6;">
        نعلمكم أننا قيدنا لكم دفعة بالمبلغ المدون وقدره <strong>$amount</strong> لا غير، وذلك لقاء ...
    </div>
    
    <br><br>
    
    <div dir="rtl" style="text-align: left; margin-top: 50px;">
        توقيع المستلم:
        <hr style="width: 150px; margin-top: 2px;">
    </div>
    EOD;
    
        $pdf->writeHTML($html, true, false, true, false, '');
    
        $pdf->Output("receipt_$date.pdf", 'I'); // 'I' = عرض في المتصفح، 'D' = تحميل
    }
// سند مطالبة
public function createsandreq()
{
        return view('createsandreq');
        
    
}
public function generatesandreq(Request $request)
{
    $cust = $request->cust;
    $amount = $request->amount;
    $reason = $request->reason;
    $date = date('Y-m-d');
    // إعداد TCPDF
    $pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
    $pdf->setRTL(true);
    $pdf->SetCreator('Laravel');
    $pdf->SetTitle($title);
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(TRUE, 15);

    // إعداد الخط العربي
    $pdf->setFontSubsetting(true);
    $pdf->SetFont('freeserif', '', 16, '', true); // تأكد من توفر الخط aealarabiya
    $pdf->AddPage();

    // HTML محتوى التقرير
    $html = <<<EOD
<div style="text-align: center;">
    <h2>سند مطالبة</h2>
</div>

<table cellspacing="0" cellpadding="4" dir="rtl" style="width: 100%; font-size: 14px;">
    <tr>
        <td><strong>سند مطالبة:</strong> </td>
        
        <td><strong>التاريخ:</strong> $date</td>
    </tr>
</table>

<br><br>

<div style="text-align: center;">
    <strong>السيد / $cust</strong>
</div>

<br>

<div dir="rtl" style="font-size: 14px; line-height: 1.6;">
    نطالبكم بتسديد المبلغ المدون وقدره <strong>$amount</strong> لا غير، وذلك لقاء <strong>$reason</strong>
</div>

<br><br>

<div dir="rtl" style="text-align: left; margin-top: 50px;">
    توقيع المستلم:
    <hr style="width: 150px; margin-top: 2px;">
</div>
EOD;

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output("req_$date.pdf", 'I'); // 'I' = عرض في المتصفح، 'D' = تحميل
}

}
