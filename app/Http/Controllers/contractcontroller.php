<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contract;
use App\Models\containersize;
use App\Models\wastetype;
use App\Models\city;
use App\Models\street;
use App\Models\paytype;
use App\Models\contractpaytype;
use App\Models\payperoid;
use App\Models\invoice;
use Carbon\Carbon;
use TCPDF;
class contractcontroller extends Controller
{
    public function contractindex(Request $request)
    {
            $query = contract::where('todate','>',now());
           
    
            // Apply search filters if the search parameters are present
            if ($request->has('search_mobile') && $request->search_mobile != '') {
                $query->where('mobileno', 'like', '%' . $request->search_mobile . '%');
            }
        
            if ($request->has('search_contract_no') && $request->search_contract_no != '') {
                $query->where('id', 'like', '%' . $request->search_contract_no . '%');
            }
            if ($request->has('search_cust_name') && $request->search_cust_name != '') {
                $query->where('custname', 'like', '%' . $request->search_cust_name . '%');
            }
            // Get the filtered and paginated results
            $contracts = $query->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
            foreach ($contracts as $contract) {
                $totalInvoicesSum = invoice::where('contractid', $contract->id)->sum('total');
                $InvoicesCount = invoice::where('contractid', $contract->id)->count('id');
                $contract->totalInvoice= $totalInvoicesSum;
                $contract->countInvoice= $InvoicesCount;
                $contract->can_add_invoice = $totalInvoicesSum < $contract->cost; // Add a flag to the contract object
            }
            return view('contractindex', compact('contracts'));
    }
    public function createcontract()
    {
        return view('createcontract');
    }
    public function addcontractreq($id)
    {
        $contract = contract::findOrFail($id);
        $containersizes = containersize::all();  // Fetch all available containersize
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $contract->cityid)->get();
        return view('addcontractreq',compact('contract','containersizes','citys','streets'));
    }
    public function storecontract(Request $request)
    {
        $request->validate([
			'contractdate' => 'required|date',
            'custname' => 'required',
            'mobileno' => 'required|digits:10',
            'whatno' => 'required|digits:10',
            'contsizeid' => 'required',
            'contnum' => 'required|digits_between:1,10',
            'cost' => 'required|digits_between:1,10',
            'cityid' => 'required',
            'streetid' => 'required',
            'paytypeid' => 'required',
            'Wastetypeid' => 'required', // Only required if bankname is not null
            'location' => 'required',
            'note' => 'required',
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',
            'emptycost' => 'required|digits_between:1,10',
            'Commregister'=>'required',
            'address'=>'required',
            'emptynum'=>'required',
            'payperoidid' => 'nullable|digits_between:1,10',
        ]);
        $startDate = \Carbon\Carbon::parse($request->input('fromdate'));
        $endDate = \Carbon\Carbon::parse($request->input('todate'));
    
        // Get payment method and contract period
        $paymentMethod = $request->input('paytypeid');
        $dueDate = null;

        // Payment method 1 (Full payment at the end of the contract)
        if ($paymentMethod == 1) {
            $dueDate = $endDate; // Due date is the end date of the contract
        }
        elseif ($paymentMethod == 3) {
            $dueDate = $startDate; // Due date is the contract start date
        }
        elseif ($paymentMethod == 4) {
            $dueDate = $startDate; // Due date is the contract start date
        }
        elseif ($paymentMethod == 2) {
            $contractPeriod = $request->input('payperoidid');
            switch ($contractPeriod) {
                case 4: // Annual installments
                    $dueDate = $startDate->addYear();
                    break;
                case 3: // Semi-annual installments
                    $dueDate = $startDate->addMonths(6);
                    break;
                case 2: // Quarterly installments
                    $dueDate = $startDate->addMonths(3);
                    break;
                case 1: // Monthly installments
                    $dueDate = $startDate->addMonth();
                    break;
                default:
                    // Handle invalid period if necessary
                    return back()->withErrors('Invalid contract period');
            }
            // Ensure due date does not exceed the contract's end date
            if ($dueDate->greaterThan($endDate)) {
                $dueDate = $endDate;
            }
        }
        $request->merge(['duedate' => $dueDate]);
        contract::create($request->post());
        return redirect()->route('contractindex')->with('success','contract has been created successfully.');
    }
    public function contractedit($id)
    {
        $contract = contract::findOrFail($id);
        $containersizes = containersize::all();  // Fetch all available containersize
        $wastetypes = wastetype::all();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $contract->cityid)->get();
        $paytypes = contractpaytype::all();  // Fetch all available containersize
        $payperoids = payperoid::all();
        return view('contractedit',compact('contract','payperoids','containersizes','wastetypes','citys','streets','paytypes'));
    }
    public function contractupdate(Request $request,$id)
    {
        $contract = contract::findOrFail($id);
        $request->validate([
			'contractdate' => 'required|date',
            'custname' => 'required',
            'mobileno' => 'required|digits:10',
            'whatno' => 'required|digits:10',
            'contsizeid' => 'required',
            'contnum' => 'required|digits_between:1,10',
            'cost' => 'required|digits_between:1,10',
            'cityid' => 'required',
            'streetid' => 'required',
            'paytypeid' => 'required',
            'Wastetypeid' => 'required', // Only required if bankname is not null
            'location' => 'required',
            'note' => 'required',
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',
            'emptycost' => 'required|digits_between:1,10',
            'Commregister'=>'required',
            'address'=>'required',
            'emptynum'=>'required',
            'payperoidid' => 'nullable|digits_between:1,10',
        ]);
        $startDate = \Carbon\Carbon::parse($request->input('fromdate'));
        $endDate = \Carbon\Carbon::parse($request->input('todate'));
    
        // Get payment method and contract period
        $paymentMethod = $request->input('paytypeid');
        $dueDate = null;

        // Payment method 1 (Full payment at the end of the contract)
        if ($paymentMethod == 1) {
            $dueDate = $endDate; // Due date is the end date of the contract
        }
        elseif ($paymentMethod == 3) {
            $dueDate = $startDate; // Due date is the contract start date
        }
        elseif ($paymentMethod == 4) {
            $dueDate = $startDate; // Due date is the contract start date
        }
        elseif ($paymentMethod == 2) {
            $contractPeriod = $request->input('payperoidid');
            switch ($contractPeriod) {
                case 4: // Annual installments
                    $dueDate = $startDate->addYear();
                    break;
                case 3: // Semi-annual installments
                    $dueDate = $startDate->addMonths(6);
                    break;
                case 2: // Quarterly installments
                    $dueDate = $startDate->addMonths(3);
                    break;
                case 1: // Monthly installments
                    $dueDate = $startDate->addMonth();
                    break;
                default:
                    // Handle invalid period if necessary
                    return back()->withErrors('Invalid contract period');
            }
            // Ensure due date does not exceed the contract's end date
            if ($dueDate->greaterThan($endDate)) {
                $dueDate = $endDate;
            }
        }
        $request->merge(['duedate' => $dueDate]);


        $contract->fill($request->post())->save();
        
        return redirect()->route('contractindex')->with('success','containerrequest Has Been updated successfully');
    }
    public function destroycontract($id)
    {
        $contract = contract::findOrFail($id);
        $contract->delete();
        return redirect()->route('contractindex');
    }
    
    public function showcontractReport(Request $request)
    {
        // التحقق من صحة التاريخ المدخل
        $request->validate([
            
            'tdate' => 'required|date',
        ]);

        // استلام التاريخ المدخل
        
        $tdate = Carbon::parse($request->input('tdate'))->format('Y-m-d');

        // استعلام البيانات بناءً على تاريخ fromdate
        $salesData = contract::where('fromdate', '<=', $tdate)  // العقد يبدأ قبل أو عند tdate
        ->where('todate', '>=', $tdate)
            ->join('container', 'contract.contnum', '=', 'container.id') // ربط مع جدول الحاويات
            ->join('contractpaytype', 'contract.paytypeid', '=', 'contractpaytype.id')
            ->join('containersize', 'contract.contsizeid', '=', 'containersize.id')
            ->join('payperoid', 'contract.payperoidid', '=', 'payperoid.id') // ربط مع جدول السائقين
            ->select(
                'container.no as container_no',
                'containersize.name as container_size',
                'contract.cost as amount',
                'contractpaytype.name as payment_method',
                'payperoid.name as payperoid',
                'contract.fromdate as fromdate',
                'contract.todate as todate',
                'contract.id as contract_no',
                'contract.custname as customer_name'
            )
            ->get();

        // إرسال البيانات إلى دالة توليد التقرير
        $this->generatePDFSalesReport($salesData,$tdate);
    }

    public function generatePDFSalesReport($salesData,$tdate)
    {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير عقود ');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();

        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير  عقود تاريخ  - ' .$tdate, 0, 1, 'C');

        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى

        // جدول المبيعات
        $pdf->Cell(30, 10, 'رقم العقد', 1, 0, 'C');
        $pdf->Cell(30, 10, 'من تاريخ', 1, 0, 'C');
        $pdf->Cell(30, 10, 'الى تاريخ', 1, 0, 'C');
        $pdf->Cell(30, 10, 'رقم الحاوية', 1, 0, 'C');
        $pdf->Cell(30, 10, 'حجم الحاوية', 1, 0, 'C');
        $pdf->Cell(30, 10, 'المبلغ', 1, 0, 'C');
        $pdf->Cell(30, 10, 'طريقة السداد', 1, 0, 'C');
        $pdf->Cell(30, 10, 'وقت السداد', 1, 0, 'C');
        $pdf->Cell(30, 10, 'اسم الزبون', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 9);
        // إضافة البيانات إلى الجدول
        
        foreach ($salesData as $data) {
            $pdf->Cell(30, 10, $data->contract_no, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->fromdate, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->todate, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->container_no, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->container_size, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->amount, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->payment_method, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->payperoid, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->customer_name, 1, 1, 'C');
             

        }
                // إخراج التقرير
        $pdf->Output('contract_report.pdf', 'I');
    }
    
    public function createcontractreport()
    {
            return view('createcontractreport');
            
        
    }
}
