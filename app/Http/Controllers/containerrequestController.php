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
        $liftRequest = liftreq::create([
            'conreqid' => $request->reqid,
            'conreqid' => $newreqcont->reqid,
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
        $emps = employee::all();  // Fetch all available containersize
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

        if (($paytype == 1 || $paytype == 6) && $remainingAmount > 0) {
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
//نقدي 
if ($containerrequest->status == 5 && $paytype == 1) {
    //from account
    $saccountid = 20; // Add a field for car_id in your form
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
        'saccountid' => 20, // Assuming customer is source account
        'raccountid' => 3, // Destination account, could be bank or null
        'amount' => $request->input('driverpayamount'), // Transaction amount
        'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $containerrequest->id,
        
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
        
    ]);
}
// نقدي وتحويل مصرفي
if ($containerrequest->status == 5 && $paytype == 6) {
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
        
    ]);
    //from account
    $saccountid = 20; // Add a field for car_id in your form
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
        'saccountid' => 20, // Assuming customer is source account
        'raccountid' => 3, // Destination account, could be bank or null
        'amount' => $request->input('driverpayamount'), // Transaction amount
        'type' => 1, // Assuming type 1 means "سند قبض" (Receipt Voucher)
        'reqid' => $containerrequest->id,
        
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
        
    ]);
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

        return redirect()->route('reqdel')->with('success','containerrequest has been send to driver successfully'); // Redirect back to the same page
    }
    public function send($id)
    {
        $request = containerrequest::find($id);
        if ($request) {
            $request->status = 2;
            
           $empid= $request->empid; 
           $driver=employee::find($empid);
           if ($driver) {
           $fullname=$driver->fullname;
           $request->save();
            return redirect()->back()->with('success', 'Request sent to driver'. $fullname);
             }
             else
             return redirect()->back()->with('success', 'Request not sent,  driver not found.');
        }

        return redirect()->back()->with('error', 'Request not found'); 
           
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
     return redirect()->route('contractindex')->with('success','containerrequest has been created successfully.');
    }
    public function getRequests()
    {
        $requests = containerrequest::where('status', 5)->where('islift',0)->get();
        return response()->json($requests);
    }

}
