<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\purchaseorder;
use App\Models\purchaseorderdtl;
use App\Models\secclass;
use App\Models\account;
use App\Models\sand;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TCPDF;
class purchaseordercontroller extends Controller
{
    public function createpurchase()
    {
        $secclasss = secclass::all(); // جلب جميع المواد لإدراجها في القائمة
        return view('createpurchase', compact('secclasss'));
    }
    public function purchasestore(Request $request)
    {
        $request->validate([
            'faccount' => 'required',
            'daccount' => 'required',
            'total' => 'required',
            'purchdate' => 'required|date',
            'secclasss' => 'required|array',
            'quantities' => 'required|array',
            'prices' => 'required|array',
            'tprices' => 'required|array',
           
        ]);
        \DB::beginTransaction(); 
        try {
        // إنشاء المذكرة
        $stock = purchaseorder::create([
            'faccount' => $request->faccount,
            'daccount' => $request->daccount,
            'purchdate' => $request->purchdate,
            'total' =>$request->total,
        ]);

        // إضافة تفاصيل المذكرة
        foreach ($request->secclasss as $index => $itemId) {
           
            purchaseorderdtl::create([
                'purchid' => $stock->id,
                'itemid' => $itemId,
                'num' => $request->quantities[$index],
                'price' => $request->prices[$index],
                'tprice' => $request->tprices[$index],
            ]);
        }
        $faccount = account::find($stock->faccount);
    if ($faccount) {
        $faccount->outamount =$faccount->outamount+$request->input('amount');
        $faccount->balance =$faccount->inamount-$faccount->outamount;
        $faccount->save();
    }
    $taccount = account::find($stock->daccount);
    if ($taccount) {
        $taccount->inamount =$taccount->inamount+$request->input('amount');
        $taccount->balance =$taccount->inamount-$taccount->outamount;
        $taccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' =>  $stock->purchdate, // Current date
        'saccountid' => $stock->faccount, // Assuming customer is source account
        'raccountid' =>  $stock->daccount, // Destination account, could be bank or null
        'amount' =>  $stock->total, // Transaction amount
        'type' => 2, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reason' =>'فاتورة شراء رقم'.$stock->id ,
    ]);
        \DB::commit(); // Commit transaction if everything is OK
        return redirect()->route('createpurchase')->with('success', 'تمت إضافة طلب الشراء بنجاح');

    } catch (\Exception $e) {
        \DB::rollBack(); // Rollback transaction if any error occurs
        return redirect()->back()->withErrors(['حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage()]);
    }

    }


    public function showpurchaseReport(Request $request)
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
        $salesData = purchaseorder::whereDate('purchaseorder.purchdate', '>=', $fdate)
        ->whereDate('purchaseorder.purchdate', '<=', $tdate)// العقد يبدأ قبل أو عند tdate
        ->leftJoin('account as sa', 'purchaseorder.faccount', '=', 'sa.id')
        ->leftJoin('account as ra', 'purchaseorder.daccount', '=', 'ra.id')
        ->select(
            'purchaseorder.id',               // رقم السند
            'purchaseorder.purchdate',         // تاريخ السند
            'purchaseorder.total',           // المبلغ الإجمالي
            'sa.name as faccount',
            'ra.name as taccount'
            )
            ->get();

        // إرسال البيانات إلى دالة توليد التقرير
        $this->generatePDFpurchaseReport($salesData,$fdate,$tdate);
    }

    public function generatePDFpurchaseReport($salesData,$fdate,$tdate)
    {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF('', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير فواتير الشراء ');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();

        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير فواتير الشراء  من تاريخ  - ' .$fdate .' الى '. $tdate, 0, 1, 'C');

        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى

        // جدول المبيعات
        $pdf->Cell(30, 10, 'رقم الفاتورة', 1, 0, 'C');
        $pdf->Cell(30, 10, 'تاريخ الفاتورة', 1, 0, 'C');
        $pdf->Cell(30, 10, ' المبلغ', 1, 0, 'C');
        $pdf->Cell(40, 10, 'من حساب', 1, 0, 'C');
        $pdf->Cell(40, 10, ' الى حساب', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 9);
        // إضافة البيانات إلى الجدول
        
        foreach ($salesData as $data) {
            $pdf->Cell(30, 10, $data->id, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->purchdate, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->total, 1, 0, 'C');
            $pdf->Cell(40, 10, $data->faccount, 1, 0, 'C');
            $pdf->Cell(40, 10, $data->taccount, 1, 1, 'C');
     
        }
                // إخراج التقرير
        $pdf->Output('purchases_report.pdf', 'I');
    }
    
    public function createpurchasereport()
    {
            return view('createpurchasereport');
            
        
    }
}
