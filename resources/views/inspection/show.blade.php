@extends('layouts.app')

@section('title', 'Inspection Detailed')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Inspections</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('inspections.index') }}">Inspections</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">Inspection Details</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Inspection Detailed</h4>
                        <a href="{{ route('inspections.index') }}" class="btn btn-rounded btn-primary btn-sm">
                            <i class="fas fa-angle-left"></i> Back
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Jobcard Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Jobcard No</th>
                                        <td>{{ $inspection->jobcard->jobcard_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer</th>
                                        <td>{{ $inspection->jobcard->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ $inspection->created_at->format('d-M-Y H:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Status Details</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Body Condition</th>
                                        <td>
                                            <span class="badge badge-{{ $inspection->body_condition == 'ok' ? 'success' : 'danger' }}">
                                                {{ strtoupper($inspection->body_condition) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Display Status</th>
                                        <td>
                                            <span class="badge badge-{{ $inspection->display_status == 'working' ? 'success' : 'danger' }}">
                                                {{ str_replace('_', ' ', strtoupper($inspection->display_status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Motherboard</th>
                                        <td>
                                            <span class="badge badge-{{ $inspection->motherboard_status == 'ok' ? 'success' : 'danger' }}">
                                                {{ strtoupper($inspection->motherboard_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Power Card</th>
                                        <td>
                                            <span class="badge badge-{{ $inspection->power_card_status == 'ok' ? 'success' : 'danger' }}">
                                                {{ strtoupper($inspection->power_card_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sensor Status</th>
                                        <td>
                                            <span class="badge badge-{{ $inspection->sensor_status == 'ok' ? 'success' : 'danger' }}">
                                                {{ strtoupper($inspection->sensor_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-8">
                                <h5>Remarks</h5>
                                <div class="p-3 bg-light border rounded">
                                    {{ $inspection->remarks ?? 'No remarks provided.' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5>Inspection Photo</h5>
                                @if($inspection->photo)
                                    <div class="border rounded p-2 text-center bg-light">
                                        <a href="{{ asset($inspection->photo) }}" target="_blank">
                                            <img src="{{ asset($inspection->photo) }}" alt="Inspection Photo" style="max-width: 100%; border-radius: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                        </a>
                                        <p class="mt-2 text-muted small">Click to view full size</p>
                                    </div>
                                @else
                                    <div class="border rounded p-4 text-center bg-light text-muted">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p>No photo available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('inspections.edit', $inspection->id) }}" class="btn btn-primary">Edit Inspection</a>
                        <a href="{{ route('jobcards.show', $inspection->jobcard_id) }}" class="btn btn-info">View Jobcard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
