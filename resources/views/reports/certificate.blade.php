<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Calibration Certificate - {{ $jobcard->jobcard_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #000;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .motto {
            font-size: 14px;
            color: #555;
            font-style: italic;
        }

        .certificate-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
        }

        .info-value {
            border-bottom: 1px dotted #ccc;
        }

        .section-header {
            font-weight: bold;
            color: #1a5a96;
            border-bottom: 1px solid #1a5a96;
            padding-bottom: 3px;
            margin: 15px 0 10px 0;
            text-transform: uppercase;
        }

        .data-table th {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .text-success {
            color: #28a745;
            font-weight: bold;
        }

        .text-danger {
            color: #dc3545;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            position: relative;
        }

        .result-box {
            padding: 10px;
            border: 1px solid #ddd;
            display: inline-block;
            min-width: 200px;
            font-weight: bold;
            border-radius: 5px;
        }

        .signature-box {
            position: absolute;
            right: 0;
            bottom: 0;
            text-align: center;
            width: 150px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .col-50 {
            width: 50%;
            float: left;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            {{-- <div class="logo">AUTOMAC ENGINEERS</div>
            <div class="motto">Excellency in Technology Solution</div> --}}
            <img src="{{ public_path('logo/image.png') }}" alt="" width="150" style="margin-bottom: 10px;">
            <div class="certificate-title">CALIBRATION CERTIFICATE</div>
        </div>

        <div class="row">
            <div class="col-50">
                <table class="info-table">
                    <tr>
                        <td class="info-label">ORDER NO & DATE :</td>
                        <td>{{ $jobcard->jobcard_number }} &
                            {{ \Carbon\Carbon::parse($jobcard->jobcard_date)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">BILL NO & DATE :</td>
                        <td>{{ $jobcard->bill_no ?? '-' }} / 
                            {{ $jobcard->bill_date ? \Carbon\Carbon::parse($jobcard->bill_date)->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Customer Name:</td>
                        <td>{{ $jobcard->customer_name }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Tag Number:</td>
                        <td>{{ $jobcard->tag_no }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Serial Number:</td>
                        <td>{{ $jobcard->serial_no }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-50">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Date Received:</td>
                        <td>{{ $jobcard->reciving_date }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Company:</td>
                        <td>{{ $jobcard->client->company ?? $jobcard->client->name }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Model Number:</td>
                        <td>{{ $jobcard->model_no }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Range:</td>
                        <td>{{ $jobcard->start_range }} to {{ $jobcard->end_range }} mmHg</td>
                    </tr>
                </table>
            </div>
        </div>
        @php $inspection = $jobcard->inspections->first(); @endphp

        @if ($inspection)
            <div class="section-header">INSPECTION</div>

            <div class="row">
                <div class="col-50">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Body Condition:</td>
                            <td>{{ $inspection->body_condition }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Display Status:</td>
                            <td>{{ $inspection->display_status }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Sensor:</td>
                            <td>{{ $inspection->sensor_status }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-50">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Mother Board:</td>
                            <td>{{ $inspection->motherboard_status }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Power Card:</td>
                            <td>{{ $inspection->power_card_status }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif

        @if ($jobcard->oil_filling)
            <div class="section-header">OIL FILLING</div>
            <div class="row">
                <div class="col-50">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Oil Type:</td>
                            <td>{{ $jobcard->oil_filling->oil_type }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Filling Date:</td>
                            <td>{{ \Carbon\Carbon::parse($jobcard->oil_filling->filling_date)->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-50">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Quantity:</td>
                            <td>{{ $jobcard->oil_filling->quantity }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Filled By:</td>
                            <td>{{ $jobcard->oil_filling->filled_by }}</td>
                        </tr>
                    </table>
                </div>
            </div>

                        <div class="section-header">Diaphragm</div>

            <table class="info-table">
                <tr>
                    <td class="info-label">MOC :</td>
                    <td>{{ $jobcard->oil_filling->moc->name ?? 'N/A' }}</td>
                    <td class="info-label">FLANGE :</td>
                    {{-- @dd($jobcard->oil_filling) --}}
                    <td>{{ $jobcard->oil_filling->flange->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="info-label">CAPILLARY :</td>
                    <td colspan="3">{{ $jobcard->oil_filling->capillary->name ?? 'N/A' }}</td>
                </tr>
            </table>
        @endif

        @if ($jobcard->calibration)
            <div class="section-header">CALIBRATION DATA</div>
            <div class="row">
                <div class="col-50">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Calibrated By:</td>
                            <td>{{ $jobcard->calibration->calibration_by }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Certificate No:</td>
                            <td>{{ $jobcard->calibration->certificate_number }}</td>
                        </tr>
                         <tr>
                            <td class="info-label">Temperature:</td>
                            <td>{{ $jobcard->calibration->temperature }} °C</td>
                        </tr>
                    </table>
                </div>
                <div class="col-50">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Date:</td>
                            <td>{{ $jobcard->calibration->date }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Instrument:</td>
                            <td>{{ $jobcard->calibration->instrument }}</td>
                        </tr>
                         <tr>
                            <td class="info-label">Humidity:</td>
                            <td>{{ $jobcard->calibration->humidity }} %</td>
                        </tr>
                    </table>
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Set Point %</th>
                        <th>Expected</th>
                        <th>As Found</th>
                        <th>As Left</th>
                        <th style="width: 15%;">Error</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobcard->calibration->points as $point)
                        <tr>
                            <td>{{ $point->set_point_percentage }}</td>
                            <td>{{ number_format($point->expected, 4) }}</td>
                            <td>{{ number_format($point->as_found, 4) }}</td>
                            <td>{{ number_format($point->as_left, 4) }}</td>
                            <td class="{{ $point->error == 0 ? 'text-success' : '' }}">
                                {{ number_format($point->error, 4) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer">
                <div class="result-box">
                    @if ($jobcard->calibration->result == 'pass')
                        <span class="text-success">✔ Overall Result: Pass</span>
                    @else
                        <span class="text-danger">✘ Overall Result: Fail</span>
                    @endif
                </div>

                <div class="signature-box">
                    <div class="signature-line">Authorized By</div>
                </div>
            </div>
        @endif
    </div>

</body>

</html>
