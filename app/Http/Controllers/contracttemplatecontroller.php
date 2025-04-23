<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contracttemplate;
use App\Models\contracttemdtl;
class contracttemplatecontroller extends Controller
{
    public function getcontems(Request $request)
    {
        // Fetch categories from the database
        $contracttemplates = contracttemplate::all();

        // Return data as JSON
        return response()->json($contracttemplates);
    }
    public function createcontracttemplate() {
        return view('createcontracttemplate');
    }

    public function contracttemplatestore(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'contracttems' => 'required|array',
            'contracttems.*.name' => 'required|string',
            'contracttems.*.descr' => 'required|string',
            'contracttems.*.rank' => 'required|numeric|min:0',
        ]);
        $template = contracttemplate::create([
            'name' => $request->name,
                    ]);
       // dd($request->all());
        foreach ($request->contracttems as $contracttem) {
            contracttemdtl::create([
                'contemid' => $template->id,
                'name' => $contracttem['name'],
                'descr' => $contracttem['descr'],
                'rank' => $contracttem['rank'],
                'val' => $contracttem['val'],
            ]);
        }

        return redirect()->back()->with('success', 'Template saved successfully!');
    }
}
