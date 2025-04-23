<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\evaluation;
use App\Models\empevaluation;
use App\Models\empevaluationdtl;
use App\Models\evaltemplatedtl;
use App\Models\employee;
use Illuminate\Support\Facades\DB;
use TCPDF;
class empevaluationcontroller extends Controller
{
    public function showEvaluations($employeeId) {
        $evaluations = evaluation::whereNotIn('id', function($query) use ($employeeId) {
            $query->select('temid')
                  ->from('empevaluation')
                  ->where('empid', $employeeId);
        })->get();
    
        return view('employee-evaluation-list', compact('evaluations', 'employeeId'));
    }

    public function loadEvaluationDetails($evaluationId, $employeeId) {
        $evaluationDetails = evaltemplatedtl::where('temid', function($query) use ($evaluationId) {
            $query->select('temid')->from('evaluation')->where('id', $evaluationId);
        })->get();

        return view('employee-evaluation-form', compact('evaluationDetails', 'evaluationId', 'employeeId'));
    }

    public function store(Request $request) {
        $request->validate([
            'empid' => 'required',
            'temid' => 'required',
            'employee_marks' => 'required|array',
        ]);

        $templateMark = array_sum(array_column($request->employee_marks, 'template_mark'));
        $employeeTotalMark = array_sum(array_column($request->employee_marks, 'employee_mark'));
        $temid = $request->input('temid'); // Add a field for car_id in your form
        $eva = evaluation::find($temid);
        $evaluation = empevaluation::create([
            'empid' => $request->empid,
            'temid' => $request->temid,
            'empmark' => $employeeTotalMark,
            'temmark' => $templateMark,
            'evaname' =>$eva->temname,
        ]);
       // dd($request->all());
        foreach ($request->employee_marks as $mark) {
            empevaluationdtl::create([
                'empevalation_id' => $evaluation->id,
                'evaluation_name' => $mark['name'],
                'mark' => $mark['template_mark'],
                'empmark' => $mark['employee_mark'],
            ]);
        }

        return redirect()->route('employeeindex')->with('success', 'Evaluation saved successfully.');
    }

    
    public function evaluationindex()
    {
        $evaluations = Evaluation::all(); // Assuming you have an 'Evaluation' model
        $employees = Employee::all(); // Get all employees or filter as necessary

        return view('evaluationindex', compact('evaluations', 'employees'));
    }

    // Method to get the filtered results based on the selected evaluation
    public function evaluationresults($evaluationId)
    {
        $employees = Employee::join('empevaluation', 'employee.id', '=', 'empevaluation.empid')
                             ->select('employee.fullname', 'empevaluation.empmark', 'empevaluation.temmark')
                             ->where('empevaluation.temid', $evaluationId) // Filter by evaluation ID
                             ->get();

        // Return the table view with the updated employee results
        return view('partials.evaluation_table', compact('employees'));

    }
    public function showevaReport($evaluationId) {
        $employees = Employee::join('empevaluation', 'employee.id', '=', 'empevaluation.empid')
                             ->select('employee.fullname', 'empevaluation.empmark', 'empevaluation.temmark')
                             ->where('empevaluation.temid', $evaluationId) // Filter by evaluation ID
                             ->get();
        $this->generatePDFReport($employees,$evaluationId);
    }
    public function generatePDFReport($employees,$evaluationId) {
        // إنشاء كائن TCPDF
        $evaluation = empevaluation::where('temid', $evaluationId) // Filter by evaluation ID
        ->get();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        
        // إعدادات الوثيقة
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('تقرير التقييم');
        $pdf->SetFont('freeserif', '', 14);
        $pdf->setRTL(true);

        // إضافة صفحة
        $pdf->AddPage();
    
        // عنوان التقرير
        $pdf->SetFont('freeserif', 'B', 16);
        $pdf->Cell(0, 10, 'تقرير التقييم '.$evaluation->first()->evaname, 0, 1, 'C');
    
        // إعداد الخط
        $pdf->SetFont('freeserif', '', 12);
    
        // إضافة محتويات التقرير
        $pdf->Ln(10); // مسافة بين العنوان والمحتوى
    
        // جدول الحاويات
        $pdf->Cell(30, 10, ' الاسم', 1, 0, 'C');
        $pdf->Cell(30, 10, 'العلامه الاساسية', 1, 0, 'C');
        $pdf->Cell(30, 10, 'علامه الموظف', 1, 1, 'C'); // إضافة عمود المدينة والشارع
        
        $pdf->SetFont('freeserif', '', 8);
        foreach ($employees as $employee) {
            $pdf->Cell(30, 10, $employee->fullname, 1, 0, 'C');
            $pdf->Cell(30, 10, $employee->temmark, 1, 0, 'C');
            $pdf->Cell(30, 10, $employee->empmark, 1, 1, 'C'); // المدينة والشارع
           
        }
    
        // إخراج التقرير
        $pdf->Output('eval_report.pdf', 'I');
    }
}
