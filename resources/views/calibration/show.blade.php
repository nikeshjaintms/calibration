@extends('layouts.app')

@section('title', 'View Calibration')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Calibration</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('calibrations.index') }}">Calibrations</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">View Calibration</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-print">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Calibration Details</h4>
                            <div class="ms-auto">
                                <a href="{{ route('jobcards.certificate', $calibration->jobcard_id) }}" class="btn btn-success btn-round me-2" target="_blank">
                                    <i class="fa fa-file-pdf"></i> Print PDF
                                </a>
                                <button class="btn btn-primary btn-round" onclick="window.print()">
                                    <i class="fa fa-print"></i> Browser Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h6 class="mb-3">Calibration Info:</h6>
                                <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($calibration->date)->format('d/m/Y') }}</div>
                                <div><strong>Calibration By:</strong> {{ $calibration->calibration_by ?? 'N/A' }}</div>
                                <div><strong>Instrument:</strong> {{ $calibration->instrument }}</div>
                                <div><strong>Certificate No:</strong> {{ $calibration->certificate_number }}</div>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h6 class="mb-3">Related Jobcard:</h6>
                                <div><strong>Jobcard No:</strong> {{ $calibration->jobcard->jobcard_number }}</div>
                                <div><strong>Customer:</strong> {{ $calibration->jobcard->customer_name }}</div>
                                <div><strong>Range:</strong> {{ $calibration->jobcard->start_range }} to {{ $calibration->jobcard->end_range }}</div>
                                <div><strong>Status:</strong> 
                                    @if($calibration->result == 'pass')
                                    <span class="badge badge-success">PASS</span>
                                    @else
                                    <span class="badge badge-danger">FAIL</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-3">
                                <strong>Temperature:</strong> {{ $calibration->temperature }} °C
                            </div>
                            <div class="col-sm-3">
                                <strong>Humidity:</strong> {{ $calibration->humidity }} %
                            </div>
                        </div>

                        @php
                            $points = $calibration->points;
                            $has_data = $points->contains(fn($p) => !is_null($p->as_left) || !is_null($p->as_found));
                        @endphp

                        @if ($has_data)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 text-primary">Calibration Details (Pre-Calibration)</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Cycle</th>
                                            <th>TEST POINT IN %</th>
                                            <th>Input Pressure</th>
                                            <th>Unit</th>
                                            <th>Desired Output mA</th>
                                            <th>Measured mA</th>
                                            <th>Error</th>
                                            <th>% Error(FS)</th>
                                            <th>Status (P/F)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($points as $index => $point)
                                            @php
                                                $pct = (float) str_replace('%', '', $point->set_point_percentage);
                                                $desired = $point->desired_output ?? (4.0 + ($pct / 100.0) * 16.0);
                                                $measured = $point->as_left;
                                                $error = $point->error !== null ? $point->error : ($measured !== null ? ($measured - $desired) : null);
                                                $error_fs = $point->error_percentage !== null ? $point->error_percentage : ($error !== null ? (($error / 16.0) * 100.0) : null);
                                                $rounded_error_fs = $error_fs !== null ? round($error_fs, 4, PHP_ROUND_HALF_EVEN) : null;
                                                $status = 'PASS';
                                            @endphp
                                            <tr>
                                                @if($index === 0)
                                                    <td rowspan="5" class="fw-bold bg-light align-middle" style="writing-mode: vertical-rl; transform: rotate(180deg); width: 40px;">Increment Cycle</td>
                                                @endif
                                                <td>{{ number_format($pct, 2) }}</td>
                                                <td>{{ $point->expected == 0 ? '0' : number_format($point->expected, 4) }}</td>
                                                <td>{{ $calibration->pressure_unit ?? 'MMWC' }}</td>
                                                <td>{{ number_format($desired, 3) }}</td>
                                                <td>{{ $measured !== null ? number_format($measured, 3) : '-' }}</td>
                                                <td>{{ $error !== null ? number_format($error, 3) : '-' }}</td>
                                                <td>{{ $rounded_error_fs !== null ? number_format($rounded_error_fs, 4) : '-' }}</td>
                                                <td>
                                                    @if($status === 'PASS')
                                                        <span class="badge badge-success">PASS</span>
                                                    @elseif($status === 'FAIL')
                                                        <span class="badge badge-danger">FAIL</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        
                    </div>
                    <div class="card-footer text-muted">
                        Generated on {{ date('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .main-header, .card-action, .btn, .breadcrumbs, .page-header {
        display: none !important;
    }
    .main-panel {
        width: 100% !important;
    }
    .card {
        border: none !important;
    }
}
</style>
@endsection
