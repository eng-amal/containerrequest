<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\account;
use Illuminate\Support\Facades\DB;
class accountcontroller extends Controller
{
    public function getaccounts(Request $request)
    {
        // Fetch categories from the database
        $accounts = account::where('type','=',3)->get(['id', 'name']);
       
        // Return data as JSON
        return response()->json($accounts);
    }
    public function getaccounts2(Request $request)
    {
        // Fetch categories from the database
        
        $accounts = account::where('type','=', 1)->get(['id', 'name']);
       
        // Return data as JSON
        return response()->json($accounts);
    }
    public function getaccounts3(Request $request)
    {
        // Fetch categories from the database
        $accounts = account::where('type','=',2)->get(['id', 'name']);
       
        // Return data as JSON
        return response()->json($accounts);
    }
    public function accountindex()
    {
        $accounts = account::all();
            
            return view('accountindex', compact('accounts'));
    }
    public function createaccount()
    {
       
        return view('createaccount');
    }
    public function storeaccount(Request $request)
    {
    $request->validate([
                'name' => 'required',
                'enname' => 'required',
                'code'=>'required',
                'type'=>'required',
                'parentid'=>'nullable|digits_between:1,10',
                'balance'=>'required',

            ]);
       
        account::create($request->post());
        return redirect()->route('accountindex')->with('success','account has been created successfully.');
    }
    
    public function destroyaccount($id)
    {
        $account = account::findOrFail($id);
        $account->delete();
        return redirect()->route('accountindex')->with('success','account Has Been deleted successfully');;
    }
    public function getNextAccountCode(Request $request)
    {
        $type = $request->input('type');
        $parentid = $request->input('parentid');
    
        // Fetch parent account code if parentid is provided
        $parentAccount = null;
        if ($parentid) {
            $parentAccount = account::find($parentid);
        }
    
        $lastCode = null;
    
        // Fetch the last code based on type and parentid
        if ($type == 1) {
            $lastAccount = account::where('type', 1)->orderBy('code', 'desc')->first();
        } else {
            $lastAccount = account::where('type', $type)->where('parentid', $parentid)->orderBy('code', 'desc')->first();
        }
    
        if ($lastAccount) {
            $lastCode = $lastAccount->code;
        }
    
        // Generate new code based on type
        $newCode = '';
    
        if ($type == 1) {
            // If type 1, increment the numeric code directly
            $newCode = $lastCode ? (string)((int)$lastCode + 1) : '1';
        } elseif ($type == 2) {
            if ($lastCode) {
                // Increment last character (assuming 1 digit)
                $prefix = substr($lastCode, 0, -1);
                $lastDigit = substr($lastCode, -1);
                $newCode = $prefix . ((int)$lastDigit + 1);
            } elseif ($parentAccount) {
                // If no last code, use parent code + .1
                $newCode = $parentAccount->code . '1';
            }
        } elseif ($type == 3) {
            if ($lastCode) {
                // Increment last 2 digits
                $prefix = substr($lastCode, 0, -2);
                $lastTwoDigits = substr($lastCode, -2);
                $newCode = $prefix . str_pad(((int)$lastTwoDigits + 1), 2, '0', STR_PAD_LEFT);
            } elseif ($parentAccount) {
                // If no last code, use parent code + .01
                $newCode = $parentAccount->code . '01';
            }
        }
    
        return response()->json(['next_code' => $newCode]);
    }
    public function accountbalance()
    {
        $accounts = \DB::table('account as a')
        ->leftJoin('account as p', 'a.parentid', '=', 'p.id')
        ->select(
            'a.id',
            'a.name',
            'a.enname',
            'a.code',
            'a.type',
            \DB::raw('
                CASE 
                    WHEN a.type = 1 THEN "Master Account"
                    WHEN a.type = 2 THEN "Sub Account"
                    WHEN a.type = 3 THEN "Sub2 Account"
                    ELSE "Unknown"
                END as type_label
            '),
            'p.name as parent_name', // parent name if exists
            'a.inamount',
            'a.outamount',
            'a.balance'
        )
        ->get();
        return view('accountbalance', compact('accounts'));
    }

}
