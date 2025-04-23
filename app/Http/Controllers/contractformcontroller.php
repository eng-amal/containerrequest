<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contracttemplate;
use App\Models\contracttemdtl;
use App\Models\contractform;
use App\Models\contractformdtl;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use TCPDF;
class contractformcontroller extends Controller
{
    public function showcontracttemplates() {
        $contracttemplates = contracttemplate::all();
        return view('contracttemplate-list', compact('contracttemplates'));
    }

    public function loadcontracttemplateDetails($contracttemplateId) {
        $contracttemplateDetails = contracttemdtl::where('contemid',$contracttemplateId)->get();

        return view('contracttemplate-form', compact('contracttemplateDetails', 'contracttemplateId'));
    }

    public function storecontractform(Request $request) {
        $request->validate([
            'contracttemid' => 'required',
            'employee_marks' => 'required|array',
        ]);
    
        try {
            // Start database transaction
            DB::beginTransaction();
    
            // Create the contract form
            $contracttemplate = contractform::create([
                'contracttemid' => $request->contracttemid,
            ]);
    
            if (!$contracttemplate) {
                throw new \Exception('Failed to create contract form.');
            }
    
            // Save contract details
            foreach ($request->employee_marks as $mark) {
                $contractDetail = contractformdtl::create([
                    'contractformid' => $contracttemplate->id,
                    'name' => $mark['name'],
                    'descr' => $mark['descr'],
                    'rank' => $mark['rank'],
                    'val' => $mark['val'],
                ]);
    
                if (!$contractDetail) {
                    throw new \Exception('Failed to save contract details.');
                }
            }
    
            // Commit the transaction if everything is successful
            DB::commit();
    
            // Generate report URL
        $reportUrl = route('contract.report', ['contracttemplateId' => $contracttemplate->id]);

        // Return a JSON response with the success message and the report URL
        return response()->json([
            'success' => true,
            'reportUrl' => $reportUrl,
        ]);
    
        } catch (\Exception $e) {
            // Rollback if there's any error
            DB::rollBack();
    
            // Return a JSON response with the error message
        return response()->json([
            'success' => false,
            'error' => 'Error: ' . $e->getMessage(),
        ]);
        }
       
    }
    public function showReport($contracttemplateId)
{
    $contractDetails = contractformdtl::where('contractformid', $contracttemplateId)->get();

        // Create new TCPDF object
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        // Set document information (optional)
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Contract Report');
        $pdf->SetSubject('Contract Report Subject');
        $pdf->SetFont('freeserif', '', 16); // Set font to Helvetica, regular, size 16

        // Set text color (RGB format)
        $pdf->SetTextColor(0, 0, 255);
         // Use "freeserif" font, which supports Arabic.

        // Add a page
        $pdf->AddPage();

        // Write the content (Arabic text, or any contract details)
        $pdf->Write(0, 'عقد رقم '. $contracttemplateId, '', 0, 'C', true, 0, false, false, 0);
       // Set font for Arabic
       $currentDate = date('Y-m-d H:i:s');  // Example format: 2025-04-03 12:30:00

// Combine contract template ID and current date into a string for the QR code
$dataForQR = '$contracttemplateId . ' | ' . $currentDate';

// Set font for the text (optional)
$pdf->SetFont('helvetica', '', 12);

$style = array(
    'position' => 'R', // Right-aligned
    'fgcolor' => array(0, 0, 0), // Black color
    'bgcolor' => false, // Transparent background
    'border' => false, // No border
    'padding' => 4, // Padding for the QR code
    'hpadding' => 'auto', // Horizontal padding
    'vpadding' => 'auto' // Vertical padding
);

// Call the write2DBarcode method with proper positioning
$pdf->write2DBarcode($dataForQR, 'QRCODE,H', 10, 10, 20, 20, $style, 'N');

       $pdf->SetFont('freeserif', '', 12);
       $pdf->SetTextColor(0, 0, 0);
        // Add contract details
        $pdf->Ln(10); // First empty row
        $pdf->Ln(10);
        foreach ($contractDetails as $detail) {
            $pdf->Write(0, $detail->descr . ': ' . $detail->val, '', 0, 'R', true, 0, false, false, 0);
        }
        $pdf->SetFont('freeserif', '', 14);

        $pdf->Ln(10); // First empty row
        $pdf->Ln(10); // Second empty row
    
        // Set font for signatures
        $pdf->SetFont('freeserif', '', 14);
    
        $pdf->Cell(90, 10, 'توقيع الفريق الأول', 0, 0, 'L'); // First Party (Right Side)
        $pdf->Cell(90, 10, 'توقيع الفريق الثاني', 0, 1, 'R'); // Second Party (Left Side)
    
        
        $pdf->Output('contract_report.pdf', 'I');
    
    
}
}
