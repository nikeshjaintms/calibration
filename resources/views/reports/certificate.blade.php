<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Calibration Certificate - {{ $jobcard->jobcard_number }}</title>
    <style>
        @page {
            margin: 25px 35px 20px 35px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #000;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }
        .header-logo-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .header-logo-container td {
            padding: 0;
            border: none;
        }
        .certificate-title-box {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            font-size: 12.5px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }
        .grid-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 10px;
            vertical-align: middle;
            height: 18px;
        }
        .label-cell {
            font-weight: bold;
        }
        .value-cell {
            background-color: #fff;
        }
        .section-header-row {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            background-color: #fff;
        }
        .result-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 4px;
        }
        .checklist-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 4px;
        }
        .footer-line {
            border: none;
            border-top: 1px solid #000;
            margin-top: 25px;
            margin-bottom: 4px;
        }
        .footer-text {
            text-align: center;
            font-size: 8px;
            line-height: 1.35;
        }
        .footer-links {
            color: #0066cc;
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Logo in upper right -->
    <table class="header-logo-container">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: right; vertical-align: middle;">
                @if(file_exists(public_path('logo/image.png')))
                    <img src="{{ public_path('logo/image.png') }}" alt="AUTOMAC" height="42">
                @else
                    <span style="font-size: 15px; font-weight: bold;">AUTOMAC ENGINEERS</span>
                @endif
            </td>
        </tr>
    </table>

    <!-- Main Title with borders -->
    <div class="certificate-title-box">
        Certificate of test, Calibration - Warranty
    </div>

    <!-- Metadata Grid Table -->
    <table class="grid-table" style="margin-bottom: 0;">
        <tr>
            <td class="label-cell" style="width: 15%;">Customer</td>
            <td class="value-cell" style="width: 25%;">{{ $jobcard->client->company ?? $jobcard->client->name ?? $jobcard->customer_name }}</td>
            <td class="label-cell" style="width: 15%;">Your Order No.</td>
            <td class="value-cell" style="width: 15%;">{{ $jobcard->calibration->po_no ?? '-' }}</td>
            <td class="label-cell" style="width: 15%;">Order Date</td>
            <td class="value-cell" style="width: 15%;">{{ $jobcard->calibration->po_date ? \Carbon\Carbon::parse($jobcard->calibration->po_date)->format('d.m.Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Instrument details</td>
            <td class="value-cell">{{ $jobcard->calibration->instrument ?? $jobcard->model_no }}</td>
            <td class="label-cell">Certificate No.</td>
            <td class="value-cell" style="font-weight: bold;">{{ $jobcard->calibration->certificate_number }}</td>
            <td class="label-cell">Cal. date</td>
            <td class="value-cell">{{ $jobcard->calibration->date ? \Carbon\Carbon::parse($jobcard->calibration->date)->format('d.m.Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Serial No.</td>
            <td class="value-cell">{{ $jobcard->serial_no }}</td>
            <td class="label-cell">Warranty</td>
            <td class="value-cell">{{ $jobcard->calibration->warranty ?? '12 MONTHS' }}</td>
            <td class="label-cell">Warranty due on</td>
            <td class="value-cell">{{ $jobcard->calibration->warranty_due_date ? \Carbon\Carbon::parse($jobcard->calibration->warranty_due_date)->format('d.m.Y') : '-' }}</td>
        </tr>
    </table>

    <!-- Calibration Standard details connected directly with no margin -->
    <table class="grid-table" style="margin-top: -1px;">
        <tr>
            <td colspan="4" class="section-header-row" style="padding: 4px; letter-spacing: 0.5px; border-top: 1px solid #000;">
                Calibration Standard
            </td>
        </tr>
        <tr>
            <td class="label-cell" style="width: 25%;">Digital pressure calibrator</td>
            <td class="value-cell" style="width: 25%;">Accuracy: {{ $jobcard->calibration->master_accuracy ?? '± 0.0003%' }}</td>
            <td class="label-cell" style="width: 15%;">Calibration method</td>
            <td class="value-cell" style="width: 35%;">{{ $jobcard->calibration->calibration_method ?? 'Compression' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Hart communicator / Field communicator make</td>
            <td class="value-cell" colspan="3">{{ $jobcard->calibration->communicator_make ?: 'Prisys (Brazil), SKE, Automac, Siemens' }}</td>
        </tr>
        <tr>
            <td class="label-cell">Activity</td>
            <td class="value-cell" colspan="3">{{ $jobcard->calibration->activity ?? '-' }}</td>
        </tr>
    </table>

    <!-- Work Details Section -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 12px; font-size: 10px; line-height: 1.45;">
        <tr>
            <td style="width: 80px; font-weight: bold; vertical-align: top; padding: 0;">Work details</td>
            <td style="width: 10px; font-weight: bold; vertical-align: top; padding: 0;">:</td>
            <td style="vertical-align: top; padding: 0; text-align: justify;">
                {{ $jobcard->calibration->work_details ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Result Table Section -->
    <div class="result-title">Result</div>
    <table class="grid-table" style="text-align: center;">
        <thead>
            <tr style="font-weight: bold;">
                <td style="width: 18%; font-weight: bold;">Unit</td>
                <td style="width: 12%; font-weight: bold;">Applied Pressure</td>
                <td style="width: 12%; font-weight: bold;">Up Reading</td>
                <td style="width: 16%;"></td>
                <td style="width: 11%; font-weight: bold;">Down Reading</td>
                <td style="width: 10%;"></td>
                <td style="width: 11%; font-weight: bold;">Diff. in Reading</td>
                <td style="width: 10%;"></td>
                <td style="width: 10%; font-weight: bold;">Accuracy in %</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobcard->calibration->points as $point)
                <tr>
                   <td style="font-weight: bold;">
    @if($loop->first)
        {{ $jobcard->calibration->pressure_unit ?? 'MMWC' }}
    @endif
</td>
                    <td>
                        {{ $point->expected == 0 ? '0' : number_format($point->expected, 2) }}
                    </td>
                    <td>
                        {{ $point->as_found !== null ? ($point->as_found == 0 ? '0' : number_format($point->as_found, 2)) : '-' }}
                    </td>
                    <td></td>
                    <td>
                        {{ $point->as_left !== null ? ($point->as_left == 0 ? '0' : number_format($point->as_left, 2)) : '-' }}
                    </td>
                    <td></td>
                    <td>
                        {{ $point->error !== null ? ($point->error == 0 ? '0' : number_format($point->error, 2)) : '-' }}
                    </td>
                    <td></td>
                    <td>
                        {{ $point->error_percentage !== null ? ($point->error_percentage == 0 ? '0' : number_format($point->error_percentage, 1)) : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Checklist Section -->
    <div class="checklist-title">Checklist</div>
    <table class="grid-table">
        <tr>
            <td style="font-weight: bold; width: 12%; background-color: #fff;">Enclosure</td>
            <td style="width: 8%;"></td>
            <td style="font-weight: bold; width: 14%; background-color: #fff;">Diaphragm MOC</td>
            <td style="width: 8%;"></td>
            <td style="font-weight: bold; width: 12%; background-color: #fff;">Connection</td>
            <td style="width: 8%;"></td>
            <td style="font-weight: bold; width: 14%; background-color: #fff;">Welding Quality</td>
            <td style="width: 8%;"></td>
            <td style="font-weight: bold; width: 10%; background-color: #fff;">Display</td>
            <td style="width: 8%;"></td>
        </tr>
    </table>

    <!-- Declarations -->
    <div style="font-size: 10px; line-height: 1.45; margin-top: 15px; margin-bottom: 25px; text-align: justify;">
        <div style="margin-bottom: 8px;">
            This notification serves to certify that the unit described above as been inspected and tested in accordance with specifications published by Instrumentation inc.
        </div>
        <div>
            The accuracy & calibration of this instrument are traceable through reference standards that are compared, at planned intervals, To national standards maintained by the NABL, By comparison to natural physical constants.
        </div>
    </div>

    <!-- Signatures Area -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 35px; margin-bottom: 10px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div style="font-size: 11px; font-weight: bold; font-family: 'Helvetica', Arial, sans-serif; padding-left: 5px;">Calibration by</div>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: bottom;">
                
            </td>
        </tr>
    </table>

    <!-- Bottom Footer -->
    <div style="text-align: center; margin-top: 25px; margin-bottom: 15px;">
        <div style="font-size: 10px; font-family: 'Helvetica', 'Arial', sans-serif; color: #000; text-transform: uppercase; margin-bottom: 5px;">
            PLOT NO. 627/2, PALEJ GIDC, N.H. 48, DIST. BHARUCH, GUJARAT- 392220, INDIA
        </div>
        <div style="font-size: 12px; font-family: 'Helvetica', 'Arial', sans-serif; color: #0056b3; text-transform: uppercase;">
            <u>HELPLINE - 8511188601, EMAIL - <span style="text-transform: lowercase;">info@automac.in</span>, <span style="text-transform: lowercase;">website - www.automac.in</span></u>
        </div>
    </div>

</body>
</html>
