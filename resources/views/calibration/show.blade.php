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

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Set Point %</th>
                                        <th>Expected Value</th>
                                        <th>As Found</th>
                                        <th>As Left</th>
                                        <th>Error</th>
                                        <th>Error %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calibration->points as $point)
                                    <tr>
                                        <td>{{ $point->set_point_percentage }}</td>
                                        <td>{{ $point->expected }}</td>
                                        <td>{{ $point->as_found ?? '-' }}</td>
                                        <td>{{ $point->as_left ?? '-' }}</td>
                                        <td>{{ $point->error }}</td>
                                        <td>{{ number_format($point->error_percentage, 4) }} %</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
