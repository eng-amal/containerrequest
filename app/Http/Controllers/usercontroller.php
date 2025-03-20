<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;

class usercontroller extends Controller
{
    public function userindex()
    {
    // Get the filtered and paginated results
            $users = user::all(); // You can change 10 to the number of rows per page
        
            return view('userindex', compact('users'));
    }
    public function createuser()
    {
       
        return view('createuser');
    }
    public function storeuser(Request $request)
    {
       // dd($request->all());
    // Validate input data
    $request->validate([
        'username' => 'required|unique:users,username', // Direct unique check
        'password' => 'required|min:6',
        'empid'    => 'required|unique:users,empid',    // Direct unique check
    ]);
   // dd('Here');
    // If validation passes, create the user
    User::create([
        'username' => $request->username,
        'password' => Hash::make($request->password), // Hashing password
        'empid'    => $request->empid,
    ]);

    return redirect()->route('userindex')->with('success', 'User has been created successfully.');
    }
    public function destroyuser($id)
    {
        $user = user::findOrFail($id);
        $user->delete();
        return redirect()->route('userindex')->with('success','user Has Been deleted successfully');;
    }
    public function resetPassword($id)
    {
        // Find the user by their ID
        $user = User::findOrFail($id);

        // Update the password to '123456' (hashed)
        $user->password = Hash::make('123456'); // Hash the password
        $user->save();

        // Redirect back with success message
        return redirect()->route('userindex')->with('success', 'Password reset successfully to 123456');
    }
}
