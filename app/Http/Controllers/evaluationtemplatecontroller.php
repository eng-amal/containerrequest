<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\evaluationtemplate;
use App\Models\evaltemplatedtl;
class evaluationtemplatecontroller extends Controller
{
    public function gettems(Request $request)
    {
        // Fetch categories from the database
        $evaluationtemplates = evaluationtemplate::all();

        // Return data as JSON
        return response()->json($evaluationtemplates);
    }
    public function createevaluationtemplate() {
        return view('createevaluationtemplate');
    }

    public function evaluationtemplatestore(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'evaluations' => 'required|array',
            'evaluations.*.name' => 'required|string',
            'evaluations.*.mark' => 'required|numeric|min:0',
        ]);
        $template = evaluationtemplate::create([
            'name' => $request->name,
            'totalmark' => $request->totalmark,
        ]);
       // dd($request->all());
        foreach ($request->evaluations as $evaluation) {
            evaltemplatedtl::create([
                'temid' => $template->id,
                'name' => $evaluation['name'],
                'mark' => $evaluation['mark'],
            ]);
        }

        return redirect()->back()->with('success', 'Template saved successfully!');
    }
}
