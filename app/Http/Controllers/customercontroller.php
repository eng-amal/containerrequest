<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
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
            ]);
       
        customer::create($request->post());
        return redirect()->route('customerindex')->with('success','customer has been created successfully.');
    }
    public function customeredit($id)
    {
        $customer = customer::findOrFail($id);
        return view('customeredit',compact('customer'));
    }
    public function customerupdate(Request $request,$id)
    {
        $customer = customer::findOrFail($id);
        $request->validate([
            'phone' => 'required|unique:customer',
            'whatappno' => 'required',
            'status'=>'required',
            'balance'=>'nullable|digits_between:1,10',
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
}
