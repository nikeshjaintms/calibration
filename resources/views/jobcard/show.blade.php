@extends('layouts.app')

@section('title', 'Jobcard Details')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-3">Jobcard Detailed View</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('jobcards.index') }}">Jobcards</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Detailed View</a></li>
                </ul>
            </div>
            <div>
                <a href="{{ route('jobcards.index') }}" class="btn btn-primary btn-round">
                    <i class="fas fa-angle-left"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-with-nav">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Jobcard: {{ $jobcard->jobcard_number }}</h4>
                            </div>
                            <div class="col-auto">
                                @php
                                    $allDone = ($jobcard->inspections->count() > 0 && $jobcard->oilFilling && $jobcard->calibration);
                                @endphp
                                <span class="badge badge-{{ $allDone ? 'success' : 'warning' }} px-3 py-2">
                                    {{ $allDone ? 'Completed' : 'In Progress' }}
                                </span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <ul class="nav nav-tabs nav-line nav-color-primary" id="jobcardTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="job-info-tab" data-bs-toggle="tab" href="#job-info" role="tab" aria-selected="true">Job Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="inspection-tab" data-bs-toggle="tab" href="#inspection" role="tab" aria-selected="false">Inspection</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="diaphragm-tab" data-bs-toggle="tab" href="#diaphragm" role="tab" aria-selected="false">Diaphragm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="oil-fill-tab" data-bs-toggle="tab" href="#oil-fill" role="tab" aria-selected="false">Oil Fill</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="calibration-tab" data-bs-toggle="tab" href="#calibration" role="tab" aria-selected="false">Calibration</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="print-tab" data-bs-toggle="tab" href="#print" role="tab" aria-selected="false">Print</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="jobcardTabContent">
                            <!-- Job Info Tab -->
                            <div class="tab-pane fade show active" id="job-info" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr><th class="bg-light" style="width: 40%;">Jobcard No</th><td>{{ $jobcard->jobcard_number }}</td></tr>
                                            <tr><th class="bg-light">Jobcard Date</th><td>{{ $jobcard->jobcard_date }}</td></tr>
                                            <tr><th class="bg-light">Bill No / Date</th><td>{{ $jobcard->bill_no ?? '-' }} / {{ $jobcard->bill_date ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Customer Name</th><td>{{ $jobcard->customer_name }}</td></tr>
                                            <tr><th class="bg-light">Client / Company</th><td>{{ $jobcard->client->name ?? 'N/A' }}</td></tr>
                                            <tr><th class="bg-light">Status</th><td><span class="badge badge-{{ $jobcard->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($jobcard->status) }}</span></td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr><th class="bg-light" style="width: 40%;">Receiving Date</th><td>{{ $jobcard->reciving_date }}</td></tr>
                                            <tr><th class="bg-light">Tag No</th><td>{{ $jobcard->tag_no }}</td></tr>
                                            <tr><th class="bg-light">Model No</th><td>{{ $jobcard->model_no }}</td></tr>
                                            <tr><th class="bg-light">Serial No</th><td>{{ $jobcard->serial_no }}</td></tr>
                                            <tr><th class="bg-light">Range</th><td>{{ $jobcard->start_range }} to {{ $jobcard->end_range }}</td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Inspection Tab -->
                            <div class="tab-pane fade" id="inspection" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                    <h5>Inspection History</h5>
                                    <a href="{{ route('inspections.create', ['jobcard_id' => $jobcard->id]) }}" class="btn btn-primary btn-sm">Add New Inspection</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Body</th>
                                                <th>Display</th>
                                                <th>Mainboard</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($jobcard->inspections as $inspection)
                                            <tr>
                                                <td>{{ $inspection->created_at->format('d-m-Y') }}</td>
                                                <td><span class="badge badge-{{ $inspection->body_condition == 'ok' ? 'success' : 'danger' }}">{{ ucfirst($inspection->body_condition) }}</span></td>
                                                <td><span class="badge badge-{{ $inspection->display_status == 'working' ? 'success' : 'danger' }}">{{ str_replace('_', ' ', ucfirst($inspection->display_status)) }}</span></td>
                                                <td><span class="badge badge-{{ $inspection->motherboard_status == 'ok' ? 'success' : 'danger' }}">{{ ucfirst($inspection->motherboard_status) }}</span></td>
                                                <td>{{ $inspection->remarks ?? '-' }}</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="5" class="text-center">No inspections found.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Diaphragm Tab -->
                            <div class="tab-pane fade" id="diaphragm" role="tabpanel">
                                <div class="text-center py-5">
                                    <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                                    <h5>Diaphragm Details</h5>
                                    <p class="text-muted">No specific data model for Diaphragm found. This section can be used for related technical data.</p>
                                </div>
                            </div>

                            <!-- Oil Fill Tab -->
                            <div class="tab-pane fade" id="oil-fill" role="tabpanel">
                                @if($jobcard->oil_filling)
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr><th class="bg-light" style="width: 40%;">Oil Type</th><td>{{ $jobcard->oil_filling->oil_type }}</td></tr>
                                            <tr><th class="bg-light">Quantity</th><td>{{ $jobcard->oil_filling->quantity }}</td></tr>
                                            <tr><th class="bg-light">Filling Date</th><td>{{ $jobcard->oil_filling->filling_date }}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr><th class="bg-light" style="width: 40%;">MOC</th><td>{{ $jobcard->oil_filling->moc->name ?? 'N/A' }}</td></tr>
                                            <tr><th class="bg-light">Flange</th><td>{{ $jobcard->oil_filling->flange->name ?? 'N/A' }}</td></tr>
                                            <tr><th class="bg-light">Capillary</th><td>{{ $jobcard->oil_filling->capillary->name ?? 'N/A' }}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <p><strong>Filled By:</strong> {{ $jobcard->oil_filling->filled_by }}</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{ route('oil-fillings.edit', $jobcard->oil_filling->id) }}" class="btn btn-info btn-sm">Edit Oil Filling</a>
                                </div>
                                @else
                                <div class="text-center py-5">
                                    <p class="text-muted">No Oil Filling record found for this Jobcard.</p>
                                    <a href="{{ route('oil-fillings.create', ['jobcard_id' => $jobcard->id]) }}" class="btn btn-primary btn-sm">Add Oil Filling</a>
                                </div>
                                @endif
                            </div>

                            <!-- Calibration Tab -->
                            <div class="tab-pane fade" id="calibration" role="tabpanel">
                                @if($jobcard->calibration)
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr><th class="bg-light" style="width: 40%;">Calibrated By</th><td>{{ $jobcard->calibration->calibration_by }}</td></tr>
                                            <tr><th class="bg-light">Date</th><td>{{ $jobcard->calibration->date }}</td></tr>
                                            <tr><th class="bg-light">Certificate No</th><td>{{ $jobcard->calibration->certificate_number }}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr><th class="bg-light" style="width: 40%;">Instrument</th><td>{{ $jobcard->calibration->instrument }}</td></tr>
                                            <tr><th class="bg-light">Temperature</th><td>{{ $jobcard->calibration->temperature }} °C</td></tr>
                                            <tr><th class="bg-light">Humidity</th><td>{{ $jobcard->calibration->humidity }} %</td></tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Set Point %</th>
                                                <th>Expected</th>
                                                <th>As Found</th>
                                                <th>As Left</th>
                                                <th>Error</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jobcard->calibration->points as $point)
                                            <tr>
                                                <td>{{ $point->set_point_percentage }}</td>
                                                <td>{{ $point->expected }}</td>
                                                <td>{{ $point->as_found ?? '-' }}</td>
                                                <td>{{ $point->as_left ?? '-' }}</td>
                                                <td>{{ $point->error }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-end mt-2">
                                    <a href="{{ route('calibrations.edit', $jobcard->calibration->id) }}" class="btn btn-info btn-sm">Edit Calibration</a>
                                </div>
                                @else
                                <div class="text-center py-5">
                                    <p class="text-muted">No Calibration record found for this Jobcard.</p>
                                    <a href="{{ route('calibrations.create', ['jobcard_id' => $jobcard->id]) }}" class="btn btn-primary btn-sm">Add Calibration</a>
                                </div>
                                @endif
                            </div>

                            <!-- Print Tab -->
                            <div class="tab-pane fade" id="print" role="tabpanel">
                                <div class="text-center py-5">
                                    <i class="fas fa-file-pdf fa-4x text-success mb-4"></i>
                                    <h3>Ready for Printing</h3>
                                    <p class="text-muted mb-4">You can download or print the consolidated Calibration Certificate and Job Report.</p>
                                    <a href="{{ route('jobcards.certificate', $jobcard->id) }}" class="btn btn-success btn-lg" target="_blank">
                                        <i class="fas fa-print"></i> Generate PDF Report
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
