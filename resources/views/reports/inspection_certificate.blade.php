<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Inspection Report - {{ $jobcard->jobcard_number }}</title>
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
            <img src="{{ public_path('logo/image.png') }}" alt="" width="150" style="margin-bottom: 10px;">
            <div class="certificate-title">INSPECTION REPORT</div>
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

        @if ($inspection)
            <div class="section-header">INSPECTION DETAILS</div>

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
                        @if($inspection->remarks)
                        <tr>
                            <td class="info-label">Remarks:</td>
                            <td>{{ $inspection->remarks }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            @if($inspection->photo)
            <div class="section-header">INSPECTION PHOTO</div>
            <div style="text-align: center; margin-top: 20px;">
                <img src="{{ public_path($inspection->photo) }}" style="max-width: 400px; max-height: 400px; border: 1px solid #ddd; padding: 5px;" alt="Inspection Photo">
            </div>
            @endif
        @endif

        <div class="footer">
            <div class="signature-box">
                <div class="signature-line">Authorized By</div>
            </div>
        </div>
    </div>

</body>

</html>
