<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\account;
use Illuminate\Support\Facades\DB;
use TCPDF;
class customercontroller extends Controller
{
    public function getcustomers(Request $request)
    {
        // Fetch categories from the database
        $customers = customer::all();

        // Return data as JSON
        return response()->json($customers);
    }
    public function getCustomerDetails($customerid)
    {
        // Find the customer by ID (you can adjust this logic as needed)
        $customer = Customer::where('phone', $customerid)->first();

        // Check if the customer was found
        if ($customer) {
            // Return the customer information as JSON
            return response()->json([
                'status' => 'success',
                'data' => $customer
            ]);
        } else {
            // Return an error if no customer is found
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found'
            ]);
        }
    }

    public function createCustomer(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'fullname' => 'required',
            'phone' => 'required|unique:customer',
            'whatappno' => 'required',
            
            // Add other fields as necessary
        ]);

        // Create a new customer
        $customer = customer::create([
            'fullname' => $validated['fullname'],
            'phone' => $validated['phone'],
            'whatappno' => $validated['whatappno'],
            // Add other fields as necessary
        ]);
        if ($customer){
        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully',
            'data' => $customer
        ]);}
        else {
            // Return an error if no customer is found
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not added'
            ]);}

    }  
    public function checkBalance(Request $request)
    {
        $amount = $request->input('amount');
        $customerId = $request->input('customer_id'); // Accept customer_id from request

        $customer = Customer::where('phone', $customerId)->first();

        if ($customer && $customer->balance >= $amount) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    // Check if the customer is a cash customer
    public function checkCashCustomer(Request $request)
    {
        $customerId = $request->input('customer_id');

        $customer = Customer::where('phone', $customerId)->first();

        if ($customer && $customer->status==1) {
            return response()->json(['isCashCustomer' => true]);
        }

        return response()->json(['isCashCustomer' => false]);
    }

    public function customerindex()
    {
    // Get the filtered and paginated results
            $customers = customer::all(); // You can change 10 to the number of rows per page
        
            return view('customerindex', compact('customers'));
    }
    public function createcustomers()
    {
       
        return view('createcustomers');
    }
    public function storecustomer(Request $request)
    {
    $request->validate([
            'fullname' => 'required',
            'phone' => 'required|unique:customer',
            'whatappno' => 'required',
            'status'=>'required',
            'balance'=>'nullable|digits_between:1,10',
            'accountid' => 'required|digits_between:1,10',
            ]);
       
        customer::create($request->post());
        return redirect()->route('customerindex')->with('success','customer has been created successfully.');
    }
    public function customeredit($id)
    {
        $accounts = account::all();
        $customer = customer::findOrFail($id);
        return view('customeredit',compact('customer','accounts'));
    }
    public function customerupdate(Request $request,$id)
    {
        $customer = customer::findOrFail($id);
        $request->validate([
            'phone' => 'required|unique:customer',
            'whatappno' => 'required',
            'status'=>'required',
            'balance'=>'nullable|digits_between:1,10',
            'accountid' => 'required|digits_between:1,10',
        ]);
        $customer->fill($request->post())->save();
        
        return redirect()->route('customerindex')->with('success','customer Has Been updated successfully');
    }
    public function destroycustomer($id)
    {
        $customer = customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customerindex')->with('success','customer Has Been deleted successfully');;
    }
    
    public function showcustomerReport() {
        $customers = \DB::table('customer as a')
        ->leftJoin('account as p', 'a.accountid', '=', 'p.id')
        ->select(
            'a.id',
            'a.fullname',
            'a.phone',
            \DB::raw('
                CASE 
                    WHEN a.status = 0 THEN "نقدي"
                    WHEN a.status = 1 THEN "اجل"
                    WHEN a.status = 2 THEN "مدفوع مسبقا"
                    WHEN a.status = 3 THEN "عقد"
                    ELSE "-"
                END as type_label
            '),
            'p.name', // parent name if exists
            'p.balance'
        )
        ->get();
        $this->generatePDFReport($customers);
    }
    public function generatePDFReport($customers) {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        
        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير الزبائن');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();
    
        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير الزبائن ', 0, 1, 'C');
    
        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
    
        // إضافة محتويات التقرير
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى
    
        // جدول الحاويات
        $pdf->Cell(40, 10, ' الاسم', 1, 0, 'C');
        $pdf->Cell(40, 10, 'رقم الهاتف', 1, 0, 'C');
        $pdf->Cell(40, 10, 'النوع', 1, 0, 'C'); // إضافة عمود المدينة والشارع
        $pdf->Cell(40, 10, 'اسم الحساب', 1, 0, 'C');
        $pdf->Cell(40, 10, 'رصيد', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 8);
        foreach ($customers as $customer) {
            $pdf->Cell(40, 10, $customer->fullname, 1, 0, 'C');
            $pdf->Cell(40, 10, $customer->phone, 1, 0, 'C');
            $pdf->Cell(40, 10, $customer->type_label, 1, 0, 'C'); // المدينة والشارع
            
            $pdf->Cell(40, 10, $customer->name, 1, 0, 'C');
            $pdf->Cell(40, 10, $customer->balance, 1, 1, 'C');
        }
    
        // إخراج التقرير
        $pdf->Output('customer_report.pdf', 'I');
    }

}
