<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\containerrequest;
use App\Models\containersize;
use App\Models\container;
use App\Models\city;
use App\Models\street;
use App\Models\employee;
use App\Models\paytype;
use App\Models\bank;
use App\Models\customer;
use App\Models\contract;
use App\Models\liftreq;
use Carbon\Carbon;
use TCPDF;
use Illuminate\Support\Str;
use Google_Client;
use GuzzleHttp\Client;
use Google\Service\FirebaseCloudMessaging;
class containerrequestController extends Controller
{
    public function index(Request $request)
{
    $query = containerrequest::query();

    // Apply filters based on search inputs
    if ($request->has('search_mobile') && !empty($request->search_mobile)) {
        $query->where('mobno', 'LIKE', '%' . $request->search_mobile . '%');
    }

    if ($request->has('search_container_no') && !empty($request->search_container_no)) {
        $query->where('container_no', 'LIKE', '%' . $request->search_container_no . '%');
    }

    if ($request->has('search_fdate') && !empty($request->search_fdate)) {
        $query->whereDate('reqdate', '>=', $request->search_fdate);
    }

    if ($request->has('search_tdate') && !empty($request->search_tdate)) {
        $query->whereDate('reqdate', '<=', $request->search_tdate);
    }

    if ($request->has('search_status') && !empty($request->search_status)) {
        $query->where('status', $request->search_status);
    }

    // Get filtered results with pagination
    $containerrequests = $query->paginate(10);

        return view('containerrequests.index', compact('containerrequests'));
	
}

public function reqdel()
{
	    $containerrequests = containerrequest::where('status','=',2)->orderBy('id','desc')->paginate(10);
        return view('reqdel', compact('containerrequests'));
        
	
}
public function login()
{
        return view('login');
        
	
}

public function master()
{
        return view('master');
        
	
}
public function comind()
{
	    $containerrequests = containerrequest::where('status','=',4)->orderBy('id','desc')->paginate(10);
        return view('comind', compact('containerrequests'));
        
	
}
public function contact()
    {
        return view('contact');
    } 
public function create()
    {
        return view('containerrequests.create');
    }
public function store(Request $request)
    {
        $request->validate([
			
            'custname' => 'required',
            'mobno' => 'required|digits:10',
            'whatno' => 'required|digits:10',
            'contsizeid' => 'required',
            'reqtypeid' => 'required',
            'cost' => 'required|digits_between:1,10',
            'cityid' => 'required',
            'streetid' => 'required',
            'paytypeid' => 'required',
            'payamount' => 'nullable|digits_between:1,10', // Only required if bankname is not null
            'empid' => 'required',
            'rent'=>'required|digits_between:1,10',
            'remainamount'=>'nullable|digits_between:1,10',
            'contid' => 'required',
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',
            'bankid' => 'nullable|digits_between:1,10',
            'transferimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contlocation' => 'required|url',
            'contractid' => 'nullable|digits_between:1,10',
        ]);
        $paytype=$request->input('paytypeid');
        if($paytype==6)
        {
            $request->validate([
                'payamount' => 'required|digits_between:1,10',
             ]);
        }

        $imagePath = null;
    if ($request->hasFile('transferimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('transferimg')->store('transfer_images', 'public');
        $request->merge(['transferimg' => $imagePath]);
    }
    $conId = $request->input('contid'); // Add a field for car_id in your form
     $cont = container::find($conId);
    $contno=$cont->no;
    $request->merge(['conno' => $contno]);
    $remain=$request->input('cost')-$request->input('payamount');
    $request->merge(['remainamount' => $remain]);
        $newreqcont=containerrequest::create($request->post());
      

    // Update the car status to 'rented' after the request is created
    
    if ($cont) {
        $cont->status = 1;
        $cont->save();
    }
    if ($request->filled('reqid')) {
        $contreq = containerrequest::find($request->reqid);
        $contreq->islift = 1;
        $contreq->save();
        $newcont = container::find($contreq->contid);
        if ($newcont) {
            $newcont->status = 3; // Set container status to full
            $newcont->save();
           
        }
        $liftRequest = liftreq::create([
            'conreqid' => $request->reqid,
            'linkreqid' => $newreqcont->id,
            'liftreasonid' => 1, // Or get from request if needed
            'liftprorityid' => 1, // Default status
            'empid' => $request->empid,
            'status' => 1,
            'reqtypeid' => $request->reqtypeid,
            'liftdate'=>$request->fromdate,
            'conlocation'=>$request->contlocation
        ]);
        $liftRequestId = $liftRequest->id;
        if (!$liftRequest) {
            return redirect()->back()->with('error', 'Failed to create lift request.');
        }
    }
    


        return redirect()->route('containerrequests.index')->with('success','containerrequest has been created successfully.');
    }
	public function show(containerrequest $containerrequest)
    {
        return view('request.show',compact('containerrequest'));
    }
	public function edit(containerrequest $containerrequest)
    {
        
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $paytypes = paytype::all();  // Fetch all available containersize
        $emps = employee::where('position_id',1)->get();  // Fetch all available containersize
        $banks = bank::all();  // Fetch all available containersize
        return view('containerrequests.edit',compact('containerrequest','containersizes','containers','citys','streets','paytypes','emps','banks'));
    }
    public function complatereq($id)
    {
        $containerrequest = containerrequest::findOrFail($id);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $paytypes = paytype::all();  // Fetch all available containersize
        $emps = employee::all();  // Fetch all available containersize
        $banks = bank::all();  // Fetch all available containersize
        return view('complatereq',compact('containerrequest','containersizes','containers','citys','streets','paytypes','emps','banks'));
    }
    public function comppending($id)
    {
        $containerrequest = containerrequest::findOrFail($id);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $paytypes = paytype::all();  // Fetch all available containersize
        $emps = employee::all();  // Fetch all available containersize
        $banks = bank::all();  // Fetch all available containersize
        return view('comppending',compact('containerrequest','containersizes','containers','citys','streets','paytypes','emps','banks'));
    }
    public function fillreq($id)
    {
        $containerrequest = containerrequest::findOrFail($id);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        return view('fillreq',compact('containerrequest','containersizes','containers','citys','streets'));
    }
	public function update(Request $request, containerrequest $containerrequest)
    {
        
        $request->validate([
            'contsizeid' => 'required',
            'cost' => 'required|digits_between:1,10',
            'cityid' => 'required',
            'streetid' => 'required',
            'paytypeid' => 'required',
            'payamount' => 'nullable|digits_between:1,10', // Only required if bankname is not null
            'empid' => 'required',
            'contid' => 'required',
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',
            'rent'=>'required|digits_between:1,10',
            'remainamount'=>'required|digits_between:1,10',
            'bankid' => 'nullable|digits_between:1,10',
            'transferimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contlocation' => 'required|url',
            
        ]);
        $paytype=$request->input('paytypeid');
        if($paytype==6)
        {
            $request->validate([
                'payamount' => 'required|digits_between:1,10',
             ]);
        }
        


        $imagePath = null;
    if ($request->hasFile('transferimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('transferimg')->store('transfer_images', 'public');
        $request->merge(['transferimg' => $imagePath]);
    }
    $remain=$request->input('cost')-$request->input('payamount');
    $request->merge(['remainamount' => $remain]);
    $oldConId = $containerrequest->contid;
    $conId = $request->input('contid');
    $newContainer = container::find($conId);
    if ($newContainer && $newContainer->status == 1) {
        return redirect()->back()->withErrors(['contid' => 'The container is already rented. Please select another one.']);
    }
       
        
        if ($oldConId != $conId) {
            $oldCont = container::find($oldConId);
            if ($oldCont) {
                $oldCont->status = 0; // Set old car status to 0
                $oldCont->save();
            }
        }
    
        // Update the new car status to 1
        $newcont = container::find($conId);
        if ($newcont) {
            $newcont->status = 1; // Set new car status to 1
            $newcont->save();
            $contno=$cont->no;
            $request->merge(['conno' => $contno]);
        }

        $containerrequest->fill($request->post())->save();


        return redirect()->route('containerrequests.index')->with('success','containerrequest Has Been updated successfully');
    }
    public function compendingreq(Request $request,$id)
    {
        $containerrequest = containerrequest::findOrFail($id);
        $amount=$request->input('pamount');
        $paytype=$request->input('paytypeid');
       if ($paytype==5)
        {
            $paytype1=$request->input('paytype');
            
            if($paytype1==1)
            {
                $containerrequest->driverpayamount=$amount;
                $containerrequest->remainamount=0;
                $containerrequest->status = 5;
                $containerrequest->paytypeid=1;
                $containerrequest->save();
                DB::table('sand')->insert([
                    'sanddate' => now(), // Current date
                    'saccountid' => 20, // Assuming customer is source account
                    'raccountid' => 3, // Destination account, could be bank or null
                    'amount' => $amount, // Transaction amount
                    'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
                    'reqid' => $containerrequest->id,
                    'reason' =>'طلب حاوية رقم '.$id,
                ]);
            }
            else if ($paytype1==2)
            {
                $containerrequest->payamount=$amount;
                $containerrequest->bankid=$request->input('bank');
                $containerrequest->remainamount=0;
                $containerrequest->status = 5;
                $containerrequest->paytypeid=3;
                $containerrequest->save();
                DB::table('sand')->insert([
                    'sanddate' => now(), // Current date
                    'saccountid' => 20, // Assuming customer is source account
                    'raccountid' => 5, // Destination account, could be bank or null
                    'amount' => $amount, // Transaction amount
                    'type' => 3, // Assuming type 1 means "سند قبض" (Receipt Voucher)
                    'reqid' => $containerrequest->id,
                    'reason' =>'طلب حاوية رقم '.$id,
                ]);
            }
        }
        else
        {
            if ($paytype==1)
                {
                $containerrequest->driverpayamount+=$amount;
                $containerrequest->remainamount=0;
                $containerrequest->status = 5;
                $containerrequest->save();
                DB::table('sand')->insert([
                    'sanddate' => now(), // Current date
                    'saccountid' => 20, // Assuming customer is source account
                    'raccountid' => 3, // Destination account, could be bank or null
                    'amount' => $amount, // Transaction amount
                    'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
                    'reqid' => $containerrequest->id,
                    'reason' =>'طلب حاوية رقم '.$id,
                ]);
               }
                if ($paytype==6)
                {
                    $containerrequest->driverpayamount+=$amount;
                $containerrequest->remainamount=0;
                $containerrequest->status = 5;
                $containerrequest->save();
                DB::table('sand')->insert([
                    'sanddate' => now(), // Current date
                    'saccountid' => 20, // Assuming customer is source account
                    'raccountid' => 3, // Destination account, could be bank or null
                    'amount' => $amount, // Transaction amount
                    'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
                    'reqid' => $containerrequest->id,
                    'reason' =>'طلب حاوية رقم '.$id,
                ]);
               }
                if ($paytype==3)
                {
                    $containerrequest->payamount+=$amount;
                $containerrequest->remainamount=0;
                $containerrequest->status = 5;
                $containerrequest->save();
                DB::table('sand')->insert([
                    'sanddate' => now(), // Current date
                    'saccountid' => 20, // Assuming customer is source account
                    'raccountid' => 5, // Destination account, could be bank or null
                    'amount' => $amount, // Transaction amount
                    'type' => 3, // Assuming type 1 means "سند قبض" (Receipt Voucher)
                    'reqid' => $containerrequest->id,
                    'reason' =>'طلب حاوية رقم '.$id,
                ]);
            }
        }
        return redirect()->route('index')->with('success','containerrequest Has Been complete successfully');
    }
    public function comreq(Request $request,$id)
    {
        $containerrequest = containerrequest::findOrFail($id);
        $paytype=$request->input('paytypeid');
        if (in_array($request->paytypeid, [3, 6]))
        // Validate incoming data (optional, but recommended)
      {
        $validated = $request->validate([
            'bankid' => 'required|digits_between:1,10',
            'transferimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'payamount' => 'required|digits_between:1,10',
            'action' => 'required',
            'suspensionReason' => 'required_if:action,suspend',
            'pendingAmountAction' => 'required_if:remainamount,>,0',
            'additionalSuspensionReason' => 'required_if:pendingAmountAction,suspend',
            'chargeTo' => 'required_if:pendingAmountAction,complete',
        ]);
      }  else
      {
        $validated = $request->validate([
            'bankid' => 'nullable|digits_between:1,10',
            'transferimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'payamount' => 'nullable|digits_between:1,10',
            'action' => 'required',
        'suspensionReason' => 'required_if:action,suspend',
        'pendingAmountAction' => 'required_if:remainamount,>,0',
        'additionalSuspensionReason' => 'required_if:pendingAmountAction,suspend',
        'chargeTo' => 'required_if:pendingAmountAction,complete',
        ]);
    }

        // Update the bankid and status
        $containerrequest->bankid = $validated['bankid'];
        
        $imagePath = null;
    if ($request->hasFile('transferimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('transferimg')->store('transfer_images', 'public');
        $request->merge(['transferimg' => $imagePath]);
        $containerrequest->transferimg=$imagePath;
        
    }
   
    if($paytype==2)
    {
        $customerid = $request->input('mobno');
        $amount = $request->input('cost');
        $customer = customer::where('phone', $customerid)->first();
        $customer->balance -= $amount;  // Subtract the amount
        $customer->save();
    }
    if($paytype==3)
    {
        $amount = $request->input('cost');
        $payamount= $request->input('payamount');
        if($payamount!=$amount)
        {
            return back()->withErrors(['payamount' => 'Pay Amount must be equal to the cost when Payment Type is "banktransfer"']);
        }
    }
    if($paytype==6)
    {   $oldpaymount=$containerrequest->payamount;
        $amount = $request->input('cost');
        $payamount= $request->input('payamount');
        $npayamount=$payamount;
        if($npayamount!=$oldpaymount)
        {
            return back()->withErrors(['payamount' => 'Pay Amount must be equal to the cost when Payment Type is "banktransfer"']);
        }
        $containerrequest->payamount=$npayamount;
    }
    if ($request->action === 'suspend') {
        $containerrequest->status = 14; // Suspended Status
        $containerrequest->suspension_reason = $request->suspensionReason;
    } elseif ($request->action === 'complete') {
       $remainingAmount = $containerrequest->remainamount;

        if (($paytype == 1 || $paytype == 6|| $paytype == 5) && $remainingAmount > 0) {
            if ($request->pendingAmountAction === 'suspend') {
                $containerrequest->status = 14; // Suspended Status
                $containerrequest->suspension_reason = $request->additionalSuspensionReason;
            } elseif ($request->pendingAmountAction === 'complete'){
                $containerrequest->status = 5; // Completed
                $containerrequest->charge_to = $request->chargeTo;
            }
            else{
                return back()->withErrors(['pendingAmountAction' => 'select action']);
            }
        } else {
            $containerrequest->status = 5; // Completed
        }
    }
    
        $containerrequest->save();
//add sand
if ($containerrequest->status == 5 && $paytype == 5) {
    //if is remain charge to employeeaccount
    if ($request->input('chargeTo')=='1')
    {
     //supervisor
     $empid=Auth::user()->empid;
      $employee = employee::where('id', $empid)->first();
     //from account
     $saccountid = $employee->accountid; // Add a field for car_id in your form
     $saccount = account::find($saccountid);
     if ($saccount) {
    $saccount->inamount =$saccount->inamount+$request->input('remainamount');
    $saccount->balance =$saccount->inamount-$saccount->outamount;
    $saccount->save();
    }
    }
    if ($request->input('chargeTo')=='2')
    {
      //driver
      $employee = employee::where('id', $request->input('empid'))->first();
    //from account
    $saccountid = $employee->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->inamount =$saccount->inamount+$request->input('remainamount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }

    }}
//نقدي 
if ($containerrequest->status == 5 && $paytype == 1) {
    //if is remain charge to employeeaccount
    if ($request->input('chargeTo')=='1')
    {
     //supervisor
     $empid=Auth::user()->empid;
      $employee = employee::where('id', $empid)->first();
     //from account
     $saccountid = $employee->accountid; // Add a field for car_id in your form
     $saccount = account::find($saccountid);
     if ($saccount) {
    $saccount->inamount =$saccount->inamount+$request->input('remainamount');
    $saccount->balance =$saccount->inamount-$saccount->outamount;
    $saccount->save();
    }
    }
    if ($request->input('chargeTo')=='2')
    {
      //driver
      $employee = employee::where('id', $request->input('empid'))->first();
    //from account
    $saccountid = $employee->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->inamount =$saccount->inamount+$request->input('remainamount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }

    }
    //from account
    $saccountid = 20; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->outamount =$saccount->outamount+$request->input('driverpayamount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
    //to account
    $raccountid = 3; // Add a field for car_id in your form
    $raccount = account::find($raccountid);
    if ($raccount) {
        $raccount->inamount =$raccount->inamount+$request->input('driverpayamount');
        $raccount->balance =$raccount->inamount-$raccount->outamount;
        $raccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' => now(), // Current date
        'saccountid' => 20, // Assuming customer is source account
        'raccountid' => 3, // Destination account, could be bank or null
        'amount' => $request->input('driverpayamount'), // Transaction amount
        'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $containerrequest->id,
        'reason' =>'طلب حاوية رقم '.$id,
    ]);
}
//تحويل مصرفي
if ($containerrequest->status == 5 && $paytype == 3) {
    //from account
    $saccountid = 20; // Add a field for car_id in your form
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
        'saccountid' => 20, // Assuming customer is source account
        'raccountid' => 5, // Destination account, could be bank or null
        'amount' => $request->input('payamount'), // Transaction amount
        'type' => 3, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $containerrequest->id,
        'reason' =>'طلب حاوية رقم '.$id,
    ]);
}
// نقدي وتحويل مصرفي
if ($containerrequest->status == 5 && $paytype == 6) {
   //if is remain charge to employeeaccount
   if ($request->input('chargeTo')=='1')
   {
    //supervisor
    $empid=Auth::user()->empid;
     $employee = employee::where('id', $empid)->first();
    //from account
    $saccountid = $employee->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
   $saccount->inamount =$saccount->inamount+$request->input('remainamount');
   $saccount->balance =$saccount->inamount-$saccount->outamount;
   $saccount->save();
   }
   }
   if ($request->input('chargeTo')=='2')
   {
     //driver
     $employee = employee::where('id', $request->input('empid'))->first();
   //from account
   $saccountid = $employee->accountid; // Add a field for car_id in your form
   $saccount = account::find($saccountid);
   if ($saccount) {
       $saccount->inamount =$saccount->inamount+$request->input('remainamount');
       $saccount->balance =$saccount->inamount-$saccount->outamount;
       $saccount->save();
   }

   }
    //from account

    $saccountid = 20; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->outamount =$saccount->outamount+$request->input('payamount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
    //to account
    $raccountid = 5; // Add a field for car_id in your form
    $raccount = account::find($raccountid);
    if ($raccount) {
        $raccount->inamount =$raccount->inamount+$request->input('payamount');
        $raccount->balance =$raccount->inamount-$raccount->outamount;
        $raccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' => now(), // Current date
        'saccountid' => 20, // Assuming customer is source account
        'raccountid' => 5, // Destination account, could be bank or null
        'amount' => $request->input('payamount'), // Transaction amount
        'type' => 3, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $containerrequest->id,
        'reason' =>'طلب حاوية رقم '.$id,
    ]);
    //from account
    $saccountid = 20; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->outamount =$saccount->outamount+$request->input('driverpayamount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
    //to account
    $raccountid = 3; // Add a field for car_id in your form
    $raccount = account::find($raccountid);
    if ($raccount) {
        $raccount->inamount =$raccount->inamount+$request->input('driverpayamount');
        $raccount->balance =$raccount->inamount-$raccount->outamount;
        $raccount->save();
    }
    DB::table('sand')->insert([
        'sanddate' => now(), // Current date
        'saccountid' => 20, // Assuming customer is source account
        'raccountid' => 3, // Destination account, could be bank or null
        'amount' => $request->input('driverpayamount'), // Transaction amount
        'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $containerrequest->id,
        'reason' =>'طلب حاوية رقم '.$id,
        
    ]);
}
// مدفوع مقدم
if ($containerrequest->status == 5 && $paytype == 2) {
    $customer = customer::where('phone', $customerid)->first();
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
        'reqid' => $containerrequest->id,
        'reason' =>'طلب حاوية رقم '.$id,
        
    ]);
}
if ($containerrequest->status == 5 && $paytype == 4) {
    $customer = customer::where('phone', $customerid)->first();
    //from account
    $saccountid = $customer->accountid; // Add a field for car_id in your form
    $saccount = account::find($saccountid);
    if ($saccount) {
        $saccount->inamount =$saccount->inamount+$request->input('amount');
        $saccount->balance =$saccount->inamount-$saccount->outamount;
        $saccount->save();
    }
}
        // Redirect back to the previous page
        return redirect()->route('comind')->with('success','containerrequest Has Been complete successfully');
    }

	public function cancel($id)
    {
        $containerrequest = containerrequest::find($id);
        if($containerrequest)
        {
        $containerrequest->status = 11; // Set old car status to 0
        $containerrequest->save();
        if($containerrequest->reqtypeid == 2)
        {
            $liftreq = liftreq::where('linkreqid','=',$id);
        $cont = containerrequest::find($liftreq->conreqid);
    if ($cont) {
        $cont->islift = 0;
        $cont->save();
    }
        $newcont = container::find($cont->contid);
        if ($newcont) {
            $newcont->status = 1; // Set container status to full
            $newcont->save();
           
        }
        $liftreq->delete();
        }
        $oldConId=$containerrequest->contid;
        $oldCont = container::find($oldConId);
            if ($oldCont) {
                $oldCont->status = 0; // Set old car status to 0
                $oldCont->save();
            }
        return redirect()->route('containerrequests.index')->with('success','containerrequest has been deleted successfully');
        }
    }
    
    public function delete($id)
    {
        $request = containerrequest::find($id);
        
        if ($request) {
            $request->status = 12; // Update status to 3
            $request->save();
        }
        $empid = $request->empid;
        $driver = Employee::find($empid);

    if (!$driver) {
        return redirect()->back()->with('error', 'Request not sent, driver not found.');
    }
// ✅ Send FCM Notification
if (!$driver->fcm_token) {
    return redirect()->back()->with('error', 'Driver does not have an FCM token.');
}

try {
    $this->sendFCMNotification($driver->fcm_token, 'New Job Request', 'You have a new container request assigned.');
} catch (\Exception $e) {
    \Log::error("Failed to send FCM to {$driver->fullname}: " . $e->getMessage());
    return redirect()->back()->with('error', 'Request saved, but failed to send notification.'. $e->getMessage());
}

        return redirect()->route('reqdel')->with('success','containerrequest has been send to driver successfully'); // Redirect back to the same page
    }
    public function send($id)
{
    $request = containerrequest::find($id);

    if (!$request) {
        return redirect()->back()->with('error', 'Request not found');
    }

    $empid = $request->empid;
    $driver = Employee::find($empid);

    if (!$driver) {
        return redirect()->back()->with('error', 'Request not sent, driver not found.');
    }

    $today = Carbon::today()->toDateString();

    // Check if driver is on vacation
    $onVacation = DB::table('vacation')
        ->where('empid', $empid)
        ->whereDate('vacdate', '<=', $today)
        ->whereRaw("DATE_ADD(vacdate, INTERVAL peroid DAY) > ?", [$today])
        ->exists();

    if ($onVacation) {
        return redirect()->back()->with('error', 'Cannot send request. Driver "' . $driver->fullname . '" is on vacation today.');
    }

    // Update request status
    $request->status = 2;
    $request->save();

    // ✅ Send FCM Notification
    if (!$driver->fcm_token) {
        return redirect()->back()->with('error', 'Driver does not have an FCM token.');
    }
    
    try {
        $this->sendFCMNotification($driver->fcm_token, 'New Job Request', 'You have a new container request assigned.');
    } catch (\Exception $e) {
        \Log::error("Failed to send FCM to {$driver->fullname}: " . $e->getMessage());
        return redirect()->back()->with('error', 'Request saved, but failed to send notification.'. $e->getMessage());
    }

    return redirect()->back()->with('success', 'Request sent to driver ' . $driver->fullname);
}
    public function showRequests(Request $request)
    {
        $currentDate = now();
        // Define the base query to get all ContainerRequests with status = 5
        $query = containerrequest::where('status', 5)->where('islift',0)->whereRaw('? >= DATE_SUB(todate, INTERVAL 1 DAY)', [$currentDate]);


     
        // Apply search filters if the search parameters are present
        if ($request->has('search_mobile') && $request->search_mobile != '') {
            $query->where('mobno', 'like', '%' . $request->search_mobile . '%');
        }
    
        if ($request->has('search_container_no') && $request->search_container_no != '') {
            $query->where('conno', 'like', '%' . $request->search_container_no . '%');
        }
    
        // Get the filtered and paginated results
        $containerrequests = $query->paginate(10); // You can change 10 to the number of rows per page
    
        return view('showRequests', compact('containerrequests'));
    }
    public function storecontactreq(Request $request)
    {
        $request->validate([
			'reqdate' => 'required',
            'custname' => 'required',
            'mobno' => 'required|digits:10',
            'whatno' => 'required|digits:10',
            'contsizeid' => 'required',
            'reqtypeid' => 'required',
            'cost' => 'nullable|digits_between:1,10',
            'cityid' => 'required',
            'streetid' => 'required',
            'paytypeid' => 'nullable|digits_between:1,10',
            'payamount' => 'nullable|digits_between:1,10', // Only required if bankname is not null
            'empid' => 'required',
            'contid' => 'required',
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',
            'bankid' => 'nullable|digits_between:1,10',
            'transferimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contlocation' => 'required|url',
            'contractid' => 'nullable|digits_between:1,10',
        ]);
// Extract month from the 'fromdate' field
$fromDate = \Carbon\Carbon::parse($request->input('fromdate'));
$toDate = \Carbon\Carbon::parse($request->input('todate'));
$month = $fromDate->month;

// Count the number of container requests for the same contractid and the same month
$existingRequestsCount = containerrequest::where('contractid',$request->input('contractid') )
    ->whereMonth('fromdate', $month)
    ->count();
    $existingRequestsCount=$existingRequestsCount+1;
   $contract= contract::find($request->input('contractid'));
   $contractFromDate = \Carbon\Carbon::parse($contract->fromdate);
    $contractToDate = \Carbon\Carbon::parse($contract->todate);

    if ($fromDate->lt($contractFromDate) || $fromDate->gt($contractToDate)) {
        return redirect()->back()->with('error', 'The request fromdate must be between the contract fromdate and todate.');
    }
    if ($toDate->lt($contractFromDate) || $toDate->gt($contractToDate)) {
        return redirect()->back()->with('error', 'The request todate must be between the contract fromdate and todate.');
    }
// Get the max allowed requests per contract
$contractno = $contract->emptynum*$contract->countnum;

if ($existingRequestsCount > $contractno) {
    return redirect()->back()->with('error', 'You cannot create more requests for this container this month.');
}


   $cost=0;     
$request->merge(['cost' => $cost]);
$conId = $request->input('contid'); // Add a field for car_id in your form
$cont = container::find($conId);
    $contno=$cont->no;
    $request->merge(['conno' => $contno]);
        containerrequest::create($request->post());
        

    // Update the car status to 'rented' after the request is created
   
    if ($cont) {
        $cont->status = 1;
        $cont->save();
    }
    if ($request->filled('reqid')) {
        $contreq = containerrequest::find($request->reqid);
        $contreq->islift = 1;
        $contreq->save();
        $liftRequest = liftreq::create([
            'conreqid' => $request->reqid,
            
            'liftreasonid' => 1, // Or get from request if needed
            'liftprorityid' => 1, // Default status
            'empid' => $request->empid,
            'status' => 1,
            'reqtypeid' => $request->reqtypeid,
            'liftdate'=>$request->fromdate,
            'conlocation'=>$request->contlocation
        ]);
        $liftRequestId = $liftRequest->id;
        if (!$liftRequest) {
            return redirect()->back()->with('error', 'Failed to create lift request.');
        }
    }
     return redirect()->route('contractindex')->with('success','containerrequest has been created successfully.');
    }
    public function getRequests()
    {
        $requests = containerrequest::where('status', 5)->where('islift',0)->get();
        return response()->json($requests);
    }
    public function getContactRequests(Request $request)
    {
        $firstSelectValue = $request->get('contractid');

    if (!$firstSelectValue) {
        return response()->json(['error' => 'Missing contract ID'], 400);
    }
        $requests = containerrequest::where('status', 5)->where('islift',0)->where('contractid',$firstSelectValue)->get();
        return response()->json($requests);
    }
// توليد تقرير الحاويات
    public function showContainersReport() {
        // نحصل على جميع الحاويات مع حالتها
        $containers = Container::with(['latestRequest']) // استخدام علاقة لجلب آخر طلب
            ->get()
            ->map(function($container) {
                // تحديد حالة الحاوية بناءً على الحقل status
                switch ($container->status) {
                    case 0:
                        $container->status_text = 'قابلة للتأجير';
                        $container->city_text ='-';
                        break;
                    case 1:
                        // إذا كانت مؤجرة، نتحقق من آخر طلب
                        if ($container->latestRequest) {
                            $container->status_text = 'مؤجرة حتى ' . $container->latestRequest->todate;
                            // إذا كانت حالتها منتهية
                            if (Carbon::parse($container->latestRequest->todate)->greaterThanOrEqualTo(Carbon::today())) {
                                $container->status_text = 'منتهية';
                            }
                        } else {
                            $container->status_text = 'مؤجرة';
                        }
                        $container->city_text = 'مؤجرة للزبون ' . $container->latestRequest->custname . 
                                            ' - المدينة: ' . $container->latestRequest->city->name . 
                                            ' - الشارع: ' . $container->latestRequest->street->name;
                        $container->emp_text ='اسم السائق : '. $container->latestRequest->employee->fullname;
                        break;
                    case 3:
                        $container->status_text = 'فول';
                        if ($container->latestRequest) {
                            $container->city_text = 'مؤجرة للزبون ' . $container->latestRequest->custname . 
                            ' - المدينة: ' . $container->latestRequest->city->name . 
                            ' - الشارع: ' . $container->latestRequest->street->name;
                            $container->emp_text ='اسم السائق : '. $container->latestRequest->employee->fullname;
                        }
                        break;
                    case 4:
                        $container->status_text = 'مرفوعة';
                        if ($container->latestRequest) {
                            $container->city_text = 'مؤجرة للزبون ' . $container->latestRequest->custname . 
                            ' - المدينة: ' . $container->latestRequest->city->name . 
                            ' - الشارع: ' . $container->latestRequest->street->name;
                            $container->emp_text ='اسم السائق : '. $container->latestRequest->employee->fullname;
                        }
                        break;
                    case 65:
                        $container->status_text = 'لم يتم تفريغها';
                        if ($container->latestRequest) {
                            $container->city_text = 'مؤجرة للزبون ' . $container->latestRequest->custname . 
                            ' - المدينة: ' . $container->latestRequest->city->name . 
                            ' - الشارع: ' . $container->latestRequest->street->name;
                            $container->emp_text ='اسم السائق : '. $container->latestRequest->employee->fullname;
                        }
                        break;
                    default:
                        $container->status_text = 'غير محددة';
                        break;
                }
                return $container;
            });
    
        // الآن سنمرر البيانات إلى الـ TCPDF لإنشاء التقرير
        $this->generatePDFReport($containers);
    }

    public function generatePDFReport($containers) {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        
        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير الحاويات');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();
    
        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير الحاويات وحالتها', 0, 1, 'C');
    
        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
    
        // إضافة محتويات التقرير
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى
    
        // جدول الحاويات
        $pdf->Cell(20, 10, 'رقم الحاوية', 1, 0, 'C');
        $pdf->Cell(40, 10, 'الحالة', 1, 0, 'C');
        $pdf->Cell(70, 10, 'المدينة / الشارع', 1, 0, 'C'); // إضافة عمود المدينة والشارع
        $pdf->Cell(40, 10, 'السائق', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 8);
        foreach ($containers as $container) {
            $pdf->Cell(20, 10, $container->no, 1, 0, 'C');
            $pdf->Cell(40, 10, $container->status_text, 1, 0, 'C');
            $pdf->Cell(70, 10, $container->city_text, 1, 0, 'C'); // المدينة والشارع
            $pdf->Cell(40, 10, $container->emp_text, 1, 1, 'C');
        }
    
        // إخراج التقرير
        $pdf->Output('containers_report.pdf', 'I');
    }



    public function showDailySalesReport(Request $request)
    {
        // التحقق من صحة التاريخ المدخل
        $request->validate([
            'date' => 'required|date',
        ]);

        // استلام التاريخ المدخل
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');

        // استعلام البيانات بناءً على تاريخ fromdate
        $salesData = containerrequest::whereDate('fromdate', $date)
            ->whereNull('contractid')
            ->where('status', 5)
            ->join('container', 'containerrequest.contid', '=', 'container.id') // ربط مع جدول الحاويات
            ->join('paytype', 'containerrequest.paytypeid', '=', 'paytype.id')
            ->join('containersize', 'containerrequest.contid', '=', 'containersize.id')
            ->join('employee', 'containerrequest.empid', '=', 'employee.id') // ربط مع جدول السائقين
            ->select(
                'container.no as container_no',
                'containersize.name as container_size',
                'containerrequest.cost as amount',
                'paytype.name as payment_method',
                'employee.fullname as driver_name',
                'containerrequest.payamount as amount_paid',
                'containerrequest.driverpayamount as damount_paid',
                'containerrequest.remainamount as amount_due',
                'containerrequest.custname as customer_name',
                DB::raw('
                CASE 
                    WHEN containerrequest.charge_to = 1 THEN "مشرف"
                    WHEN containerrequest.charge_to=2  THEN "سائق"
                    
                    ELSE "-"
                END as chargeto
            '),
            )
            ->get();

        // إرسال البيانات إلى دالة توليد التقرير
        $this->generatePDFSalesReport($salesData, $date);
    }

    public function generatePDFSalesReport($salesData, $date)
    {
        // إنشاء كائن TCPDF
        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير مبيعات يومية');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();

        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير مبيعات يومية - ' . $date, 0, 1, 'C');

        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى

        // جدول المبيعات
        $pdf->Cell(30, 10, 'رقم الحاوية', 1, 0, 'C');
        $pdf->Cell(30, 10, 'حجم الحاوية', 1, 0, 'C');
        $pdf->Cell(30, 10, 'المبلغ', 1, 0, 'C');
        $pdf->Cell(30, 10, 'طريقة السداد', 1, 0, 'C');
        $pdf->Cell(30, 10, 'اسم السائق', 1, 0, 'C');
        $pdf->Cell(30, 10, 'المبلغ المسدد', 1, 0, 'C');
        $pdf->Cell(30, 10, 'المبلغ المسدد للسائق', 1, 0, 'C');
        $pdf->Cell(30, 10, 'المبلغ المتبقي', 1, 0, 'C');
        $pdf->Cell(30, 10, 'على حساب', 1, 0, 'C');
        $pdf->Cell(30, 10, 'اسم الزبون', 1, 1, 'C');
        $pdf->SetFont('freeserif', '', 9);
        // إضافة البيانات إلى الجدول
        $totals = [];
        $ftotal=0;
        $fftotal=0;
        $ffftotal=0;
        foreach ($salesData as $data) {
            $pdf->Cell(30, 10, $data->container_no, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->container_size, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->amount, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->payment_method, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->driver_name, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->amount_paid, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->damount_paid, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->amount_due, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->chargeto, 1, 0, 'C');
            $pdf->Cell(30, 10, $data->customer_name, 1, 1, 'C');
             // تجميع المبالغ حسب طريقة الدفع
        $paymentMethod = $data->payment_method;
        if (!isset($totals[$paymentMethod])) {
            $totals[$paymentMethod] = 0;
        }
        if ($paymentMethod == 'نقدي') {
            $totals[$paymentMethod] += $data->damount_paid;
        }
        else if ($paymentMethod == 'مدفوع مقدم') {
            $totals[$paymentMethod] += $data->amount;
        }
        else if ($paymentMethod == 'تحويل بنكي') {
            $totals[$paymentMethod] += $data->amount_paid;
        }
        else if ($paymentMethod == 'نقدي وتحويل') {
            $totals[$paymentMethod] += $data->amount_paid+$data->damount_paid;
        }
        else {
            $totals[$paymentMethod] += $data->amount;
        }
        $ftotal+=$data->amount;
        $fftotal+=$data->amount_paid+$data->damount_paid;

        }
        $pdf->Ln(5);

        // **إضافة إجمالي المبيعات حسب طريقة الدفع**
        $pdf->SetFont('freeserif', 'B', 12);
        $pdf->Cell(0, 10, 'إجمالي المبيعات حسب طريقة الدفع:', 0, 1, 'C');
    
        foreach ($totals as $method => $total) {
            $pdf->Cell(100, 10, 'طريقة الدفع: ' . $method, 1, 0, 'C');
            $pdf->Cell(50, 10, 'المجموع: ' . number_format($total, 2) . ' ريال', 1, 1, 'C');
        }
        $pdf->Cell(100, 10, ' المبلغ الكلي: ', 1, 0, 'C');
        $pdf->Cell(50, 10, 'المجموع: ' . number_format($ftotal, 2) . ' ريال', 1, 1, 'C');
        $pdf->Cell(100, 10, ' المبلغ المدفوع: ', 1, 0, 'C');
        $pdf->Cell(50, 10, 'المجموع: ' . number_format($fftotal, 2) . ' ريال', 1, 1, 'C');
        $pdf->Cell(100, 10, ' المبلغ المتبقي: ', 1, 0, 'C');
        $ffftotal=$ftotal-$fftotal;
        $pdf->Cell(50, 10, 'المجموع: ' . number_format($ffftotal, 2) . ' ريال', 1, 1, 'C');
        // إخراج التقرير
        $pdf->Output('daily_sales_report.pdf', 'I');
    }
    
    public function createsalereport()
    {
            return view('createsalereport');
            
        
    }


    protected function sendFCMNotification($token, $title, $body)
{
    $client = new Google_Client();
    $client->setAuthConfig(storage_path('app/containerrequest-9e25b1d94c62.json'));
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    //$client->useApplicationDefaultCredentials();
    $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

    $projectId = env('FIREBASE_PROJECT_ID');
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    $http = new Client();

    $message = [
        'message' => [
            'token' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            // Optional: add data for Flutter background handling
            'data' => [
                'request_type' => 'job',
                'custom_id' => (string) Str::uuid(),
            ],
        ]
    ];

    $http->post($url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ],
        'json' => $message,
    ]);
}


}
