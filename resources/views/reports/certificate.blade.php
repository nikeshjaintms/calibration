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
        .cal-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .cal-details-table td, .cal-details-table th {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 9.5px;
            text-align: center;
            vertical-align: middle;
        }
        .cal-table-header {
            background-color: #9cbcd4; /* Premium blue-grey header */
            font-weight: bold;
            font-size: 11px;
            text-align: center;
            padding: 6px;
            text-transform: uppercase;
        }
        .cal-sub-header td {
            background-color: #d0e0ed;
            font-weight: bold;
            font-size: 9.5px;
        }
        .cycle-cell {
            background-color: #d0e0ed;
            font-weight: bold;
            font-size: 9px;
            width: 25px;
            line-height: 1.1;
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
    @php
        $points = $jobcard->calibration->points;
        $has_data = $points->contains(function($p) { return !is_null($p->as_found); });
        $has_left = $points->contains(function($p) { return !is_null($p->as_left); });
    @endphp

    @if ($has_data)
    <table class="cal-details-table">
        <thead>
            <tr>
                <td colspan="9" class="cal-table-header">Calibration Details (Pre-Calibration)</td>
            </tr>
            <tr class="cal-sub-header">
                <td style="width: 4%;"></td>
                <td style="width: 14%;">TEST POINT IN %</td>
                <td style="width: 14%;">Input Pressure</td>
                <td style="width: 10%;">Unit</td>
                <td style="width: 15%;">Desired Output mA</td>
                <td style="width: 14%;">Measured mA</td>
                <td style="width: 10%;">Error</td>
                <td style="width: 11%;">% Error(FS)</td>
                <td style="width: 8%;">Status (P/F)</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($points as $index => $point)
                @php
                    $pct = (float) str_replace('%', '', $point->set_point_percentage);
                    $desired = $point->as_found ?? (4.0 + ($pct / 100.0) * 16.0);
                    $measured = $point->as_left;
                    $error = $measured !== null ? ($measured - $desired) : null;
                    $error_fs = $error !== null ? (($error / 16.0) * 100.0) : null;
                    $rounded_error_fs = $error_fs !== null ? round($error_fs, 4, PHP_ROUND_HALF_EVEN) : null;
                    $status = 'PASS';
                @endphp
                <tr>
                    @if ($index === 0)
                        <td rowspan="5" class="cycle-cell">I<br>n<br>c<br>r<br>e<br>m<br>e<br>n<br>t<br><br>C<br>y<br>c<br>l<br>e</td>
                    @endif
                    <td>{{ number_format($pct, 2) }}</td>
                    <td>{{ $point->expected == 0 ? '0' : number_format($point->expected, 4) }}</td>
                    <td>{{ $jobcard->calibration->pressure_unit ?? 'MMWC' }}</td>
                    <td>{{ number_format($desired, 3) }}</td>
                    <td>{{ $measured !== null ? number_format($measured, 3) : '-' }}</td>
                    <td>{{ $error !== null ? number_format($error, 3) : '-' }}</td>
                    <td>{{ $rounded_error_fs !== null ? number_format($rounded_error_fs, 4) : '-' }}</td>
                    <td style="font-weight: bold;">{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

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
