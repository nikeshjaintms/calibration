<?php

namespace App\Http\Controllers;

use App\Models\jobcard;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function generateJobCertificate($id)
    {
        $jobcard = jobcard::with([
            'client',
            'oil_filling.moc',
            'oil_filling.flange',
            'oil_filling.capillary',
            'oil_filling',
            'calibration.points'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('reports.certificate', compact('jobcard'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Certificate_{$jobcard->jobcard_number}.pdf");
    }
}
