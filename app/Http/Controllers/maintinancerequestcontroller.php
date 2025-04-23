<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\maintinancerequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TCPDF;
use Illuminate\Support\Facades\Auth;
class maintinancerequestcontroller extends Controller
{
    
    public function maintinancerequestindex()
    {
        $maintinancerequests = DB::table('maintinancerequest as s')
        ->where('s.status','=',1)
        ->leftJoin('car as sa', 's.carid', '=', 'sa.id')
        ->leftJoin('container as ra', 's.contid', '=', 'ra.id')
        ->leftJoin('containersize as cs', 's.contsizeid', '=', 'cs.id')
        ->leftJoin('employee as e', 's.driverid', '=', 'e.id')
        ->select(
            's.id',  
            's.maindate',             // رقم السند
            's.drivernote',         // تاريخ السند
            'e.fullname',           // المبلغ الإجمالي
            'sa.no', 
            'ra.no as contname',
            'cs.name as sizename',     
            )->get();
            
            return view('maintinancerequestindex', compact('maintinancerequests'));
    }
    public function maintinancerequestindex1()
    {
        $maintinancerequests  = DB::table('maintinancerequest as s')
        ->where('s.status','=',2)
        ->leftJoin('car as sa', 's.carid', '=', 'sa.id')
        ->leftJoin('container as ra', 's.contid', '=', 'ra.id')
        ->leftJoin('containersize as cs', 's.contsizeid', '=', 'cs.id')
        ->leftJoin('employee as e', 's.driverid', '=', 'e.id')
        ->leftJoin('employee as ee', 's.empprocessid', '=', 'ee.id')
        ->select(
            's.id',  
            's.maindate', 
            's.processdate',           
            's.drivernote',
            's.processnote',       
            'e.fullname',           
            'sa.no', 
            'ra.no as contname',
            'cs.name as sizename',  
            'ee.fullname pfullname',   
            )->get();
            
            return view('maintinancerequestindex1', compact('maintinancerequests'));
    }
    public function createmaintinancerequest()
    {
       
        return view('createmaintinancerequest');
    }
    public function storemaintinancerequest(Request $request)
    {
    $request->validate([
                'carid' => 'nullable|digits_between:1,10',
                'contid' => 'nullable|digits_between:1,10',
                'drivernote'=>'required',
                'contsizeid' =>'nullable|digits_between:1,10',
            ]);
            $request->merge(['driverid' =>Auth::user()->empid]);
        maintinancerequest::create($request->post());
        return redirect()->route('createmaintinancerequest')->with('success','maintinancerequest has been created successfully.');
    }
    public function maintinancerequestedit($id)
    {
        $maintinancerequest=DB::table('maintinancerequest as s')
        ->where('s.id','=',$id)
        
        ->leftJoin('car as sa', 's.carid', '=', 'sa.id')
        ->leftJoin('container as ra', 's.contid', '=', 'ra.id')
        ->leftJoin('containersize as cs', 's.contsizeid', '=', 'cs.id')
        ->leftJoin('employee as e', 's.driverid', '=', 'e.id')
        ->select(
            's.id',  
            's.maindate',             // رقم السند
            's.drivernote',         // تاريخ السند
            'e.fullname',           // المبلغ الإجمالي
            'sa.no', 
            'ra.no as contname',
            'cs.name as sizename',     
            )->first();
        return view('maintinancerequestedit',compact('maintinancerequest'));
    }
    public function maintinancerequestclos($id)
    {
        $maintinancerequest=DB::table('maintinancerequest as s')
        ->where('s.id','=',$id)
        ->leftJoin('car as sa', 's.carid', '=', 'sa.id')
        ->leftJoin('container as ra', 's.contid', '=', 'ra.id')
        ->leftJoin('containersize as cs', 's.contsizeid', '=', 'cs.id')
        ->leftJoin('employee as e', 's.driverid', '=', 'e.id')
        ->leftJoin('employee as ee', 's.empprocessid', '=', 'ee.id')
        ->select(
            's.id',  
            's.maindate', 
            's.processdate',           
            's.drivernote',
            's.processnote',       
            'e.fullname',           
            'sa.no', 
            'ra.no as contname',
            'cs.name as sizename',  
            'ee.fullname pfullname',   
            )->first();
        return view('maintinancerequestclos',compact('maintinancerequest'));
    }
    public function maintinancerequestupdate(Request $request,$id)
    {
        $maintinancerequest = maintinancerequest::findOrFail($id);
        $request->validate([
            'processnote' => 'required',
            
        ]);
        $request->merge(['status' =>2]);
        $request->merge(['empprocessid' =>Auth::user()->empid]);
        $maintinancerequest->fill($request->post())->save();
        
        return redirect()->route('maintinancerequestindex')->with('success','maintinancerequest Has Been updated successfully');
    }
    public function maintinancerequestclose(Request $request,$id)
    {
        $maintinancerequest = maintinancerequest::findOrFail($id);
        $request->validate([
            'closenote' => 'required',
            
        ]);
        $request->merge(['status' =>3]);
        $request->merge(['empcloseid' =>Auth::user()->empid]);
        $maintinancerequest->fill($request->post())->save();
        
        return redirect()->route('maintinancerequestindex1')->with('success','maintinancerequest Has Been updated successfully');
    }


    public function showmainReport(Request $request)
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
        $salesData = maintinancerequest::whereDate('maintinancerequest.maindate', '>=', $fdate)
        ->whereDate('maintinancerequest.maindate', '<=', $tdate)// العقد يبدأ قبل أو عند tdate
        ->leftJoin('car as sa', 'maintinancerequest.carid', '=', 'sa.id')
        ->leftJoin('container as ra', 'maintinancerequest.contid', '=', 'ra.id')
        ->leftJoin('containersize as cs', 'maintinancerequest.contsizeid', '=', 'cs.id')
        ->leftJoin('employee as e', 'maintinancerequest.driverid', '=', 'e.id')
        ->leftJoin('employee as ee', 'maintinancerequest.empprocessid', '=', 'ee.id')
        ->leftJoin('employee as ec', 'maintinancerequest.empcloseid', '=', 'ec.id')
        ->select(
            'maintinancerequest.id',  
            'maintinancerequest.maindate', 
            'maintinancerequest.processdate',           
            'maintinancerequest.drivernote',
            'maintinancerequest.processnote',
            'maintinancerequest.closenote',   
            'maintinancerequest.closedate', 
            'ec.fullname as cfullname',   
            'e.fullname',           
            'sa.no', 
            'ra.no as contname',
            'cs.name as sizename',  
            'ee.fullname as pfullname',  
            DB::raw('
                CASE 
                    WHEN maintinancerequest.status = 1 THEN "طلب جديد"
                    WHEN maintinancerequest.status = 2 THEN "قيد المعالجة"
                    WHEN maintinancerequest.status = 3 THEN "تم معالجته"
                    ELSE "غير معروف"
                END as statustype
            '), 
            )->get();

        // إرسال البيانات إلى دالة توليد التقرير
        $this->generatePDFmaintinancerequestReport($salesData,$fdate,$tdate);
    }

    public function generatePDFmaintinancerequestReport($salesData,$fdate,$tdate)
    {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير طلبات الصيانه ');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();

        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير طلبات الصيانه  من تاريخ  - ' .$fdate .' الى '. $tdate, 0, 1, 'C');

        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى

        // جدول المبيعات
        $pdf->Cell(20, 10, 'رقم الطلب', 1, 0, 'C');
        $pdf->Cell(20, 10, 'تاريخ الطلب', 1, 0, 'C');
        $pdf->Cell(20, 10, ' مقدم الطلب', 1, 0, 'C');
        $pdf->Cell(20, 10, 'الحاله', 1, 0, 'C');
        $pdf->Cell(20, 10, 'ملاحظات مقدم الطلب', 1, 0, 'C');
        $pdf->Cell(20, 10, 'معالج الطلب', 1, 0, 'C');
        $pdf->Cell(20, 10, ' ملاحظات المعالج', 1, 0, 'C');
        $pdf->Cell(20, 10, ' تاريخ ', 1, 0, 'C');
        $pdf->Cell(20, 10, 'مغلق الطلب', 1, 0, 'C');
        $pdf->Cell(20, 10, 'ملاحظاته ', 1, 0, 'C');
        $pdf->Cell(20, 10, 'التاريخ ', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 9);
        // إضافة البيانات إلى الجدول
        
        foreach ($salesData as $data) {
            $pdf->Cell(20, 10, $data->id, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->maindate, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->fullname, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->statustype, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->drivernote, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->pfullname, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->processnote, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->processdate, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->cfullname, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->closenote, 1, 0, 'C');
            $pdf->Cell(20, 10, $data->closedate, 1, 1, 'C');
     
        }
                // إخراج التقرير
        $pdf->Output('maintinancerequests_report.pdf', 'I');
    }
    
    public function createmainrequestsreport()
    {
            return view('createmainrequestsreport');
            
        
    }
    
}
