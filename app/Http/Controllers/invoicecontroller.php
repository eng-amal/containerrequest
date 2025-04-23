<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\invoice;
use App\Models\contract;
use App\Models\bank;
use Carbon\Carbon;
use TCPDF;
class invoicecontroller extends Controller
{
    public function invoiceindex($id)
    {
            
            // Get the filtered and paginated results
            $invoices = invoice::where('contractid', $id)->orderBy('id','desc')->paginate(10); // You can change 10 to the number of rows per page
        
            return view('invoiceindex', compact('invoices'));
    }
    public function createinvoice($id)
    {
        $contract = contract::findOrFail($id);
        return view('createinvoice',compact('contract'));
    }
    public function storeinvoice(Request $request)
    {
        $ispay=$request->input('ispay');
        $paytype=$request->input('paytypeid');
        $contractid = $request->input('contractid');
        $newInvoiceTotal = $request->input('total');
        $contract = contract::findOrFail($contractid);
        // Get the sum of the total of invoices that belong to the same contract
        $existingInvoicesSum = invoice::where('contractid', $contractid)->sum('total');

    // Check if the sum of all invoices (existing + new) exceeds the contract's total
    if (($existingInvoicesSum + $newInvoiceTotal) > $contract->cost) {
        // If the sum exceeds the contract's total, show a message and redirect back
        return redirect()->back()->with('error', 'The total of the invoices exceeds the contract total. You cannot add more invoices.');
    }
    $dueDate = null;
    $duDate = \Carbon\Carbon::parse($contract->duedate);
    $endDate = \Carbon\Carbon::parse($contract->todate);
    if (($existingInvoicesSum + $newInvoiceTotal) < $contract->cost) {
        
        $paymentMethod=$contract->paytypeid;
        // Payment method 1 (Full payment at the end of the contract)
        if ($paymentMethod == 4) {
            $contractPeriod = $contract->payperoidid;
            switch ($contractPeriod) {
                case 4: // Annual installments
                    $dueDate = $duDate->addYear();
                    break;
                case 3: // Semi-annual installments
                    $dueDate = $duDate->addMonths(6);
                    break;
                case 2: // Quarterly installments
                    $dueDate = $duDate->addMonths(3);
                    break;
                case 1: // Monthly installments
                    $dueDate = $duDate->addMonth();
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
        elseif ($paymentMethod == 2) {
            $contractPeriod = $contract->payperoidid;
            switch ($contractPeriod) {
                case 4: // Annual installments
                    $dueDate = $duDate->addYear();
                    break;
                case 3: // Semi-annual installments
                    $dueDate = $duDate->addMonths(6);
                    break;
                case 2: // Quarterly installments
                    $dueDate = $duDate->addMonths(3);
                    break;
                case 1: // Monthly installments
                    $dueDate = $duDate->addMonth();
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
    }
    $contract->duedate=$dueDate;
    $contract->save();
        if(($paytype==2)&&($ispay==2))
        {
            $request->validate([
                'total' => 'required|digits_between:1,10',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'contractid' => 'nullable|digits_between:1,10',
                'bankid' => 'required|digits_between:1,10',
                'ispay' => 'required|digits_between:1,10',
                'paytypeid' => 'required|digits_between:1,10',
                'transferimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }
        else
        {
        $request->validate([
			'total' => 'required|digits_between:1,10',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contractid' => 'nullable|digits_between:1,10',
            'bankid' => 'nullable|digits_between:1,10',
            'ispay' => 'required|digits_between:1,10',
            'paytypeid' => 'required|digits_between:1,10',
            'transferimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
        $imagePath = null;
    if ($request->hasFile('transferimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('transferimg')->store('transfer_images', 'public');
        $request->merge(['transferimg' => $imagePath]);
    }
    
        invoice::create($request->post());
        //for sand
        if(($paytype==2)&&($ispay==2))
        {
            $customer = customer::where('phone', $contract->mobileno)->first();
    //from account
    $saccountid = $customer->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->outamount =$saccount->outamount+$request->input('amount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
    //to account
    $raccountid = 5; // Add a field for car_id in your form
    $raccount = account::find($raccountid);
    if ($raccount) {
        $raccount->inamount =$raccount->inamount+$request->input('amount');
        $raccount->balance =$raccount->inamount-$raccount->outamount;
        $raccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' => now(), // Current date
        'saccountid' => $customer->accountid, // Assuming customer is source account
        'raccountid' => 5, // Destination account, could be bank or null
        'amount' => $request->input('cost'), // Transaction amount
        'type' => 3, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $invoice->id,
        'reason' =>'فاتورة رقم'.$invoice->id.' للعقد'.$invoice->contractid,
    ]);
        }
        if(($paytype==1)&&($ispay==2))
        {
            $customer = customer::where('phone', $contract->mobileno)->first();
    //from account
    $saccountid = $customer->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->outamount =$saccount->outamount+$request->input('amount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
    //to account
    $raccountid = 3; // Add a field for car_id in your form
    $raccount = account::find($raccountid);
    if ($raccount) {
        $raccount->inamount =$raccount->inamount+$request->input('amount');
        $raccount->balance =$raccount->inamount-$raccount->outamount;
        $raccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' => now(), // Current date
        'saccountid' => $customer->accountid, // Assuming customer is source account
        'raccountid' => 3, // Destination account, could be bank or null
        'amount' => $request->input('cost'), // Transaction amount
        'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $invoice->id,
        'reason' =>'فاتورة رقم'.$invoice->id.' للعقد'.$invoice->contractid,
    ]);
        }
        return redirect()->route('contractindex')->with('success','invoice has been created successfully.');
    }
    public function invoiceedit($id)
    {
        $invoice = invoice::findOrFail($id);
        $banks = bank::all();
        return view('invoiceedit',compact('invoice','banks'));
    }
    public function invoiceupdate(Request $request,$id)
    {
        $invoice = invoice::findOrFail($id);
        $ispay=$request->input('ispay');
        $oldispay = $invoice->paytypeid; 
        $paytype=$request->input('ispay');
        if ($oldispay == 2) {
            return back()->withErrors(['paytypeid' => 'You cannot modify this invoice because it is already paid.']);
        }
        // Initialize the validation rules array
    $validationRules = [
        'total' => 'required|numeric|min:1|max:999999',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'contractid' => 'nullable|digits_between:1,10',
        'bankid' => 'nullable|digits_between:1,10',
        'ispay' => 'required|in:1,2',
        'paytypeid' => 'required|in:1,2',
        'transferimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Default is nullable
    ];

    // If `ispay == 2` and `paytypeid == 2`, we add the conditional rule for `transferimg`
    if ($paytype == 2 && $ispay == 2) {
        // If the current invoice doesn't already have a `transferimg`, make it required
        if (!$invoice->transferimg) {
            $validationRules['transferimg'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
    }

    // Validate the request data based on the rules
    $request->validate($validationRules);
        $imagePath = null;
    if ($request->hasFile('transferimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('transferimg')->store('transfer_images', 'public');
        $request->merge(['transferimg' => $imagePath]);
    }
        $invoice->fill($request->post())->save();
        $contract = contract::findOrFail($invoice->contractid);
        if(($paytype==2)&&($ispay==2))
        {
            $customer = customer::where('phone', $contract->mobileno)->first();
    //from account
    $saccountid = $customer->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->outamount =$saccount->outamount+$request->input('amount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
    //to account
    $raccountid = 5; // Add a field for car_id in your form
    $raccount = account::find($raccountid);
    if ($raccount) {
        $raccount->inamount =$raccount->inamount+$request->input('amount');
        $raccount->balance =$raccount->inamount-$raccount->outamount;
        $raccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' => now(), // Current date
        'saccountid' => $customer->accountid, // Assuming customer is source account
        'raccountid' => 5, // Destination account, could be bank or null
        'amount' => $request->input('cost'), // Transaction amount
        'type' => 3, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $invoice->id,
        'reason' =>'فاتورة رقم'.$invoice->id.' للعقد'.$invoice->contractid,
    ]);
        }
        if(($paytype==1)&&($ispay==2))
        {
            $customer = customer::where('phone', $contract->mobileno)->first();
    //from account
    $saccountid = $customer->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->outamount =$saccount->outamount+$request->input('amount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
    //to account
    $raccountid = 3; // Add a field for car_id in your form
    $raccount = account::find($raccountid);
    if ($raccount) {
        $raccount->inamount =$raccount->inamount+$request->input('amount');
        $raccount->balance =$raccount->inamount-$raccount->outamount;
        $raccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' => now(), // Current date
        'saccountid' => $customer->accountid, // Assuming customer is source account
        'raccountid' => 3, // Destination account, could be bank or null
        'amount' => $request->input('cost'), // Transaction amount
        'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $invoice->id,
        'reason' =>'فاتورة رقم'.$invoice->id.' للعقد'.$invoice->contractid,
        
    ]);
        }
        return redirect()->route('invoiceindex', $invoice->contractid)->with('success','invoice Has Been updated successfully');
    }
    public function destroyinvoice($id)
    {
        $invoice = invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoiceindex',$invoice->contractid)->with('success','invoice Has Been deleted successfully');;
    }
    public function showinvoiceReport(Request $request)
    {
        // التحقق من صحة التاريخ المدخل
        $request->validate([
            
            'tdate' => 'required|date',
        ]);

        // استلام التاريخ المدخل
        
        $tdate = Carbon::parse($request->input('tdate'))->format('Y-m-d');

        // استعلام البيانات بناءً على تاريخ fromdate
        $salesData = invoice::where('invoicedate', '=', $tdate)  // العقد يبدأ قبل أو عند tdate
            ->join('contract', 'invoice.contractid', '=', 'contract.id') // ربط مع جدول الحاويات
            ->leftjoin('bank', 'invoice.bankid', '=', 'bank.id')
            ->select(
                'invoice.id as invoice_no',
                'invoice.total as amount',
                DB::raw("COALESCE(bank.name, '-') as bankname"), 
                DB::raw("CASE 
                    WHEN invoice.ispay = 1 THEN 'غير مدفوع' 
                    ELSE ' مدفوع' 
                 END as ispay_status"),
                DB::raw("CASE 
                    WHEN invoice.paytypeid = 1 THEN 'نقدي' 
                    ELSE 'تحويل مصرفي' 
                 END as pay_type"),
                 'contract.id as contract_no',
                'contract.custname as customer_name'
            )
            ->get();

        // إرسال البيانات إلى دالة توليد التقرير
        $this->generatePDFInvoicesReport($salesData,$tdate);
    }

    public function generatePDFInvoicesReport($salesData,$tdate)
    {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير  فواتير عقود ');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();

        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير   فواتير عقود تاريخ  - ' .$tdate, 0, 1, 'C');

        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى

        // جدول المبيعات
        $pdf->Cell(30, 10, 'رقم العقد', 1, 0, 'C');
        $pdf->Cell(30, 10, 'رقم الفاتورة', 1, 0, 'C');
        $pdf->Cell(30, 10, ' المبلغ', 1, 0, 'C');
        $pdf->Cell(30, 10, 'مدفوع؟', 1, 0, 'C');
        $pdf->Cell(30, 10, 'طريقة السداد', 1, 0, 'C');
        $pdf->Cell(30, 10, ' البنك', 1, 0, 'C');
        $pdf->Cell(30, 10, 'اسم الزبون', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 9);
        // إضافة البيانات إلى الجدول
        
        foreach ($salesData as $data) {
            $pdf->Cell(30, 10, $data->contract_no, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->invoice_no, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->amount, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->ispay_status, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->pay_type, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->bankname, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->customer_name, 1, 1, 'C');
             

        }
                // إخراج التقرير
        $pdf->Output('invoices_report.pdf', 'I');
    }
    
    public function createinvoicesreport()
    {
            return view('createinvoicesreport');
            
        
    }


}
