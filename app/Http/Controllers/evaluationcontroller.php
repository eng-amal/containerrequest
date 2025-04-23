<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\evaluation;
class evaluationcontroller extends Controller
{
    public function createevaluation()
    {
       
        return view('createevaluation');
    }
    public function storeevaluation(Request $request)
    {
    $request->validate([
                'temid' => 'required',
                'temname' => 'required',
            ]);
       
        evaluation::create($request->post());
        return redirect()->back()->with('success', 'Template saved successfully!');
    }
}
