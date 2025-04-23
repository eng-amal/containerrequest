<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\liftreq;
use App\Models\containerrequest;
use App\Models\containersize;
use App\Models\container;
use App\Models\city;
use App\Models\street;
use App\Models\employee;
use App\Models\paytype;
use App\Models\bank;
use App\Models\customer;
use App\Models\unemptyreason;
use App\Models\liftprority;
use App\Models\bldeh;
use App\Models\liftreason;
use App\Models\unliftreason;
use App\Models\contlocation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Google_Client;
use GuzzleHttp\Client;
use Google\Service\FirebaseCloudMessaging;

class liftreqcontroller extends Controller
{

    public function newfillrequest()
    {
        return view('newfillrequest');
    }
    public function store(Request $request)
    {
        $request->validate([
			'conreqid' => 'required',
            'empid' => 'required',
            'liftdate' => 'required|date',
            'liftreasonid' => 'required',
            'liftprorityid' => 'required',
            'note' => 'nullable|String', // Only required if bankname is not null
            'empid' => 'required',
            'bldehid' => 'nullable|digits_between:1,10',
            'conimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'conlocation' => 'required|url',
        ]);
        


        $imagePath = null;
    if ($request->hasFile('conimg')) {
        // Store the image in the 'public' directory
        $imagePath = $request->file('conimg')->store('con_images', 'public');
        $request->merge(['conimg' => $imagePath]);
    }
        liftreq::create($request->post());
        $conId = $request->input('conreqid'); // Add a field for car_id in your form

    // Update the car status to 'rented' after the request is created
    $cont = containerrequest::find($conId);
    if ($cont) {
        $cont->islift = 1;
        $cont->save();
    }
        $newcont = container::find($cont->contid);
        if ($newcont) {
            $newcont->status = 3; // Set container status to full
            $newcont->save();
           
        }
        return redirect()->route('showRequests')->with('success','containerrequestlift has been created successfully.');
    }

    public function managefillreq()
    {
        // Using DB query to join liftreq and containerrequest
        $liftreqs = DB::table('liftreq')
            ->join('containerrequest', 'liftreq.conreqid', '=', 'containerrequest.id')
            ->select('liftreq.id','liftreq.liftdate', 'liftreq.reqdate', 'liftreq.liftprorityid','containerrequest.custname', 'containerrequest.mobno')
            ->where('liftreq.status', 1)
            ->get();

        return view('managefillreq', compact('liftreqs'));
    }

    // Edit and Delete actions remain the same as before
    public function editfill($id)
    {
        // Your logic to fetch and edit the liftreq by id
        $liftreq = liftreq::findOrFail($id);
        $containerrequest = containerrequest::findOrFail($liftreq->conreqid);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $emps = employee::where('position_id',1)->get();
        $liftproritys=liftprority::all();
        $bldehs=bldeh::all();
        $liftreasons=liftreason::all();
        return view('editfill',compact('liftreq','containerrequest','liftreasons','bldehs','liftproritys','emps','containersizes','containers','citys','streets'));
    }
    public function updatereq(Request $request,$id)
    {
        $liftreq = liftreq::findOrFail($id);
        $validated= $request->validate([
			'empid' => 'required',
            'liftdate' => 'required|date',
            'liftreasonid' => 'required',
            'liftprorityid' => 'required',
            'note' => 'nullable|String', // Only required if bankname is not null
            'bldehid' => 'nullable|digits_between:1,10',
            'conimg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'conlocation' => 'required|url',
        ]);
        $liftreq->liftdate = $validated['liftdate'];
        $liftreq->empid = $validated['empid'];
        $liftreq->liftreasonid = $validated['liftreasonid'];
        $liftreq->liftprorityid = $validated['liftprorityid'];
        $liftreq->note = $validated['note'];
        $liftreq->bldehid = $validated['bldehid'];
        $liftreq->conlocation = $validated['conlocation'];
        $imagePath = null;
        if ($request->hasFile('conimg')) {
            // Store the image in the 'public' directory
            $imagePath = $request->file('conimg')->store('con_images', 'public');
            $request->merge(['conimg' => $imagePath]);
            $liftreq->conimg=$imagePath;
        }
        $liftreq->save();
        // Redirect back to the previous page
        return redirect()->route('managefillreq')->with('success','containerrequest Has Been complete successfully');
    }
    public function send($id)
    {
        $request = liftreq::find($id);

        if (!$request) {
            return redirect()->back()->with('error', 'Request not found');
        }
    
        $empid = $request->empid;
        $driver = Employee::find($empid);
    
        if (!$driver) {
            return redirect()->back()->with('error', 'Request not sent, driver not found.');
        }
    
        $today = Carbon::today()->toDateString();
    
        // Check if driver is on vacation today
        $onVacation = DB::table('vacation')
            ->where('empid', $empid)
            ->whereDate('vacdate', '<=', $today)
            ->whereRaw("DATE_ADD(vacdate, INTERVAL peroid DAY) > ?", [$today])
            ->exists();
    
        if ($onVacation) {
            return redirect()->back()->with('error', 'Cannot send request. Driver "' . $driver->fullname . '" is on vacation today.');
        }
    
        $request->status = 2;
        $request->save();
    // ✅ Send FCM Notification
    if (!$driver->fcm_token) {
        return redirect()->back()->with('error', 'Driver does not have an FCM token.');
    }
    
    try {
        $this->sendFCMNotification($driver->fcm_token, 'New lift Request', 'You have a new container lift request assigned.');
    } catch (\Exception $e) {
        \Log::error("Failed to send FCM to {$driver->fullname}: " . $e->getMessage());
        return redirect()->back()->with('error', 'Request saved, but failed to send notification.'. $e->getMessage());
    }

    return redirect()->back()->with('success', 'Request sent to driver ' . $driver->fullname);
       
           
    }
    public function destroyfill($id)
    {
        $liftreq = liftreq::findOrFail($id);
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
        return redirect()->route('managefillreq');
    }
    public function comfillind()
    {
        // Using DB query to join liftreq and containerrequest
        $liftreqs = DB::table('liftreq')
            ->join('containerrequest', 'liftreq.conreqid', '=', 'containerrequest.id')
            ->select('liftreq.id','liftreq.liftdate', 'liftreq.reqdate', 'liftreq.liftprorityid','containerrequest.custname', 'containerrequest.mobno')
            ->where('liftreq.status', 4)
            ->get();

        return view('comfillind', compact('liftreqs'));
    }
    public function uncomfillind()
    {
        // Using DB query to join liftreq and containerrequest
        $liftreqs = DB::table('liftreq')
            ->join('containerrequest', 'liftreq.conreqid', '=', 'containerrequest.id')
            ->select('liftreq.id','liftreq.liftdate', 'liftreq.reqdate', 'liftreq.liftprorityid','containerrequest.custname', 'containerrequest.mobno')
            ->where('liftreq.status', 5)
            ->get();

        return view('uncomfillind', compact('liftreqs'));
    }
    public function compfillreq($id)
    {
        // Your logic to fetch and edit the liftreq by id
        $liftreq = liftreq::findOrFail($id);
        $containerrequest = containerrequest::findOrFail($liftreq->conreqid);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $emps = employee::all();
        $liftproritys=liftprority::all();
        $bldehs=bldeh::all();
        $liftreasons=liftreason::all();
        return view('compfillreq',compact('liftreq','containerrequest','liftreasons','bldehs','liftproritys','emps','containersizes','containers','citys','streets'));
    }
    public function uncompfillreq($id)
    {
        // Your logic to fetch and edit the liftreq by id
        $liftreq = liftreq::findOrFail($id);
        $containerrequest = containerrequest::findOrFail($liftreq->conreqid);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $emps = employee::all();
        $liftproritys=liftprority::all();
        $bldehs=bldeh::all();
        $liftreasons=liftreason::all();
        $unliftreasons=unliftreason::all();
        return view('uncompfillreq',compact('liftreq','containerrequest','liftreasons','unliftreasons','bldehs','liftproritys','emps','containersizes','containers','citys','streets'));
    }
    public function compfillreq1(Request $request,$id)
    {
        $liftreq = liftreq::findOrFail($id);
       
        $liftreq->status = 6;
       
        $liftreq->save();
        // Redirect back to the previous page
        return redirect()->route('comfillind')->with('success','containerrequest Has Been complete successfully');
    }
    public function uncompfillreq1(Request $request,$id)
    {
        $liftreq = liftreq::findOrFail($id);
        $request->validate([
           'rereqdate' => 'required|date',
        ]);
        $liftreq->status = 1;
        $liftreq->rereq = 1;
        $liftreq->empid =$request->input('empid');
        $liftreq->liftdate =$request->input('rereqdate');
        $liftreq->rereqdate =$request->input('rereqdate');
        $liftreq->save();
        // Redirect back to the previous page
        return redirect()->route('uncomfillind')->with('success','containerrequest Has Been complete successfully');
    }
    
    public function emptyind()
    {
        // Using DB query to join liftreq and containerrequest
        $liftreqs = DB::table('liftreq')
            ->join('containerrequest', 'liftreq.conreqid', '=', 'containerrequest.id')
            ->select('liftreq.id','liftreq.liftdate', 'liftreq.reqdate', 'liftreq.liftprorityid','containerrequest.custname', 'containerrequest.mobno')
            ->where('liftreq.isempty', 1)
            ->get();

        return view('emptyind', compact('liftreqs'));
    }
    public function unemptyind()
    {
        // Using DB query to join liftreq and containerrequest
        $liftreqs = DB::table('liftreq')
            ->join('containerrequest', 'liftreq.conreqid', '=', 'containerrequest.id')
            ->select('liftreq.id','liftreq.liftdate', 'liftreq.reqdate', 'liftreq.liftprorityid','containerrequest.custname', 'containerrequest.mobno')
            ->where('liftreq.isempty', 2)
            ->get();

        return view('unemptyind', compact('liftreqs'));
    }

    public function compemptyreq($id)
    {
        // Your logic to fetch and edit the liftreq by id
        $liftreq = liftreq::findOrFail($id);
        $containerrequest = containerrequest::findOrFail($liftreq->conreqid);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $emps = employee::all();
        $liftproritys=liftprority::all();
        $bldehs=bldeh::all();
        $liftreasons=liftreason::all();
        return view('compemptyreq',compact('liftreq','containerrequest','liftreasons','bldehs','liftproritys','emps','containersizes','containers','citys','streets'));
    }
    public function uncompemptyreq($id)
    {
        // Your logic to fetch and edit the liftreq by id
        $liftreq = liftreq::findOrFail($id);
        $containerrequest = containerrequest::findOrFail($liftreq->conreqid);
        $containersizes = containersize::all();  // Fetch all available containersize
        $containers = container::where('sizeid','=', $containerrequest->contsizeid)->get();
        $citys = city::all();  // Fetch all available containersize
        $streets = street::where('cityid','=', $containerrequest->cityid)->get();
        $emps = employee::all();
        $liftproritys=liftprority::all();
        $bldehs=bldeh::all();
        $liftreasons=liftreason::all();
        $unemptyreasons=unemptyreason::all();
        $contlocations=contlocation::all();
        
        return view('uncompemptyreq',compact('liftreq','containerrequest','liftreasons','contlocations','unemptyreasons','bldehs','liftproritys','emps','containersizes','containers','citys','streets'));
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
