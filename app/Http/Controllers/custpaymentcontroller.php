<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\custpayment;
use App\Models\account;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use TCPDF;
class custpaymentcontroller extends Controller
{
    public function createcustpayment()
    {
       
        return view('createcustpayment');
    }
    public function storecustpayment(Request $request)
    {
    $request->validate([
                'custid' => 'required',
                'amount' => 'required',
                'paytype' => 'required',
                'bankid' => 'nullable|digits_between:1,10',
                'transferno' => 'nullable',
            ]);
//from account
            $custid = $request->input('custid'); // Add a field for car_id in your form
            $cust = customer::find($custid);
            $saccount=account::find($cust->accountid);
            //مدفوع مسبقا
            if($cust->status==2)
            {
                $cust->balance=$cust->balance+$request->input('amount');
                $cust->save();
            }
            if ($saccount) {
                $saccount->inamount =$saccount->inamount+$request->input('amount');
                $saccount->balance =$saccount->inamount-$saccount->outamount;
                $saccount->save();
            }
            //to account
            $raccountid =23 ; // Add a field for car_id in your form
            $raccount = account::find($raccountid);
            if ($raccount) {
                $raccount->outamount =$raccount->outamount+$request->input('amount');
                $raccount->balance =$raccount->inamount-$raccount->outamount;
                $raccount->save();
            }
        custpayment::create($request->post());
        $paytype=$request->input('paytype');
        if($paytype==1)
        {
            DB::table('sand')->insert([
                'sanddate' => now(), // Current date
                'saccountid' => 23, // Assuming customer is source account
                'raccountid' => $cust->accountid, // Destination account, could be bank or null
                'amount' => $request->input('amount'), // Transaction amount
                'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
                'reqid' => null,
                'reason' =>'دفعه للزبون',
            ]);
        }
        if($paytype==2)
        {
            DB::table('sand')->insert([
                'sanddate' => now(), // Current date
                'saccountid' => 23, // Assuming customer is source account
                'raccountid' => $cust->accountid, // Destination account, could be bank or null
                'amount' => $request->input('amount'), // Transaction amount
                'type' => 3, // Assuming type 1 means "سند قبض" (Receipt Voucher)
                'reqid' => null,
                'reason' =>'دفعه للزبون',
                
            ]);
        }
        return redirect()->route('createcustpayment')->with('success','custpayment has been created successfully.');
    }
    public function generatecustpay(Request $request)
    {
        $type = $request->paytype;
        $custid = $request->custid;
        $date = date('Y-m-d');
    
        $customer = \DB::table('customer')->find($custid);
        $accountName = $customer ? $customer->fullname : '---';
        $title = $type == 1 ? 'إيصال قبض' : 'إيصال قبض حواله';
        $lastId = \DB::table('custpayment')->max('id');
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
}
