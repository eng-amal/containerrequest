<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stock;
use App\Models\Stock_mstr;
use App\Models\Stock_dtl;
use App\Models\secclass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TCPDF;
class stockcontroller extends Controller
{
    public function stockindex()
    {
    // Get the filtered and paginated results
            $stocks = stock::all(); // You can change 10 to the number of rows per page
        
            return view('stockindex', compact('stocks'));
    }
    public function createstock()
    {
        $secclasss = secclass::all(); // جلب جميع المواد لإدراجها في القائمة
        return view('stockentry', compact('secclasss'));
    }
    public function stockstore(Request $request)
    {
        $request->validate([
            'entrytype' => 'required',
            'entrydate' => 'required|date',
            'secclasss' => 'required|array',
            'quantities' => 'required|array',
           
        ]);
        \DB::beginTransaction(); 
        try {
        // إنشاء المذكرة
        $stock = stock_mstr::create([
            'entrytype' => $request->entrytype,
            'entrydate' => $request->entrydate,
        ]);

        // إضافة تفاصيل المذكرة
        foreach ($request->secclasss as $index => $itemId) {
            $quantity = $request->quantities[$index];

            // Fetch the item in stock (if exists)
            $stockItem = stock::where('itemid', $itemId)->first();

            if ($request->entrytype == 1) {
                // If "IN" Memo: Increase stock
                if ($stockItem) {
                    $stockItem->balance += $quantity;
                    $stockItem->save();
                } else {
                    // If item does not exist, create it
                    $secclass = secclass::find($itemId);
                    
                    stock::create([
                        'itemid' => $itemId,
                        'balance' => $quantity,
                        'itemname' => $secclass->name,
                        'minimum' =>$secclass->minimum,
                    ]);
                }
            } else {
                // If "OUT" Memo: Decrease stock
                if (!$stockItem) {
                    return redirect()->back()->withErrors(["المادة رقم $itemId غير موجودة في المخزون"]);
                }
                if ($stockItem->balance < $quantity) {
                    return redirect()->back()->withErrors(["المادة رقم $itemId لا تحتوي على رصيد كافٍ"]);
                }

                $stockItem->balance -= $quantity;
                $stockItem->save();
            }
            
            
            
            
            stock_dtl::create([
                'stockmstr_id' => $stock->id,
                'itemid' => $itemId,
                'amount' => $request->quantities[$index],
            ]);
        }

        \DB::commit(); // Commit transaction if everything is OK
        return redirect()->route('createstock')->with('success', 'تمت إضافة المذكرة بنجاح');

    } catch (\Exception $e) {
        \DB::rollBack(); // Rollback transaction if any error occurs
        return redirect()->back()->withErrors(['حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage()]);
    }

    }
    public function showstockReport() {
        $stocks = stock::select(
            'itemid',
            'itemname',
            'balance',
            'minimum',
            
        )
        ->get();
        $this->generatePDFReport($stocks);
    }
    public function generatePDFReport($stocks) {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        
        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير المستودع');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();
    
        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير المستودع ', 0, 1, 'C');
    
        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
    
        // إضافة محتويات التقرير
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى
    
        // جدول الحاويات
        $pdf->Cell(40, 10, ' رقم الماده', 1, 0, 'C');
        $pdf->Cell(40, 10, 'اسم الماده', 1, 0, 'C');
        $pdf->Cell(40, 10, 'الرصيد', 1, 0, 'C'); // إضافة عمود المدينة والشارع
        $pdf->Cell(40, 10, 'الحد الادنى', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 8);
        foreach ($stocks as $stock) {
            $pdf->Cell(40, 10, $stock->itemid, 1, 0, 'C');
            $pdf->Cell(40, 10, $stock->itemname, 1, 0, 'C');
            $pdf->Cell(40, 10, $stock->balance, 1, 0, 'C'); // المدينة والشارع
            $pdf->Cell(40, 10, $stock->minimum, 1, 1, 'C');
            
        }
    
        // إخراج التقرير
        $pdf->Output('stock_report.pdf', 'I');
    }
    public function showitemsReport(Request $request)
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
        $salesData = stock_mstr::whereDate('stock_mstr.entrydate', '>=', $fdate)
        ->whereDate('stock_mstr.entrydate', '<=', $tdate)// العقد يبدأ قبل أو عند tdate
        ->Join('stock_dtl', 'stock_mstr.id', '=', 'stock_dtl.stockmstr_id')
        ->Join('secclass', 'stock_dtl.itemid', '=', 'secclass.id')
        ->select(
            'stock_mstr.id',               // رقم السند
            'stock_mstr.entrydate', 
            DB::raw('
            CASE 
                WHEN stock_mstr.entrytype = 1 THEN "ادخال"
                WHEN stock_mstr.entrytype = 2 THEN "اخراج"
                ELSE "غير معروف"
            END as type_label
        '),      
            'stock_dtl.amount',           // المبلغ الإجمالي
            'secclass.name',

            )
            ->get();

        // إرسال البيانات إلى دالة توليد التقرير
        $this->generatePDFitemsReport($salesData,$fdate,$tdate);
    }

    public function generatePDFitemsReport($salesData,$fdate,$tdate)
    {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF('', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير حركه المواد ');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();

        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير حركه المواد   من تاريخ  ' .$fdate .' الى '. $tdate, 0, 1, 'C');

        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى

        // جدول المبيعات
        $pdf->Cell(30, 10, 'رقم المذكره', 1, 0, 'C');
        $pdf->Cell(30, 10, 'تاريخ المذكره', 1, 0, 'C');
        $pdf->Cell(30, 10, ' نوع الحركه', 1, 0, 'C');
        $pdf->Cell(40, 10, 'اسم الماده', 1, 0, 'C');
        $pdf->Cell(40, 10, 'العدد', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 9);
        // إضافة البيانات إلى الجدول
        
        foreach ($salesData as $data) {
            $pdf->Cell(30, 10, $data->id, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->entrydate, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->type_label, 1, 0, 'C');
            $pdf->Cell(40, 10, $data->name, 1, 0, 'C');
            $pdf->Cell(40, 10, $data->amount, 1, 1, 'C');
     
        }
                // إخراج التقرير
        $pdf->Output('items_report.pdf', 'I');
    }
    
    public function createitemsreport()
    {
            return view('createitemsreport');
            
        
    }


}
