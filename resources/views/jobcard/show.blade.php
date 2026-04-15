@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Jobcards</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jobcards.index') }}">Jobcards</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Show Jobcard</a>
                    </li>
                </ul>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('jobcards.index') }}" class="btn btn-rounded btn-primary float-end"> <i
                                    class="fas fa-angle-left"></i> Back</a>
                            <h4 class="card-title">Jobcard Detailed</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jobcard No</th>
                                            <th>Jobcard Date</th>
                                            <th>Client</th>
                                            <th>Receiving Date</th>
                                            <th>Customer Name</th>
                                            <th>Tag No</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $jobcard->jobcard_number }}</td>
                                            <td>{{ $jobcard->jobcard_date }}</td>
                                            <td>{{ $jobcard->client->name ?? 'N/A' }}</td>
                                            <td>{{ $jobcard->reciving_date }}</td>
                                            <td>{{ $jobcard->customer_name }}</td>
                                            <td>{{ $jobcard->tag_no }}</td>
                                            <td><span class="badge badge-{{ $jobcard->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($jobcard->status) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-hover mt-3">
                                    <thead>
                                        <tr>
                                            <th>Model No</th>
                                            <th>Serial No</th>
                                            <th>Start Range</th>
                                            <th>End Range</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $jobcard->model_no }}</td>
                                            <td>{{ $jobcard->serial_no }}</td>
                                            <td>{{ $jobcard->start_range }}</td>
                                            <td>{{ $jobcard->end_range }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Inspection History</h4>
                            <a href="{{ route('inspections.create', ['jobcard_id' => $jobcard->id]) }}" class="btn btn-primary btn-sm">Add New Inspection</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Body Condition</th>
                                            <th>Display</th>
                                            <th>Motherboard</th>
                                            <th>Power Card</th>
                                            <th>Sensor</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jobcard->inspections as $inspection)
                                        <tr>
                                            <td>{{ $inspection->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $inspection->body_condition == 'ok' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($inspection->body_condition) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $inspection->display_status == 'working' ? 'success' : 'danger' }}">
                                                    {{ str_replace('_', ' ', ucfirst($inspection->display_status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $inspection->motherboard_status == 'ok' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($inspection->motherboard_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $inspection->power_card_status == 'ok' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($inspection->power_card_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $inspection->sensor_status == 'ok' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($inspection->sensor_status) }}
                                                </span>
                                            </td>
                                            <td>{{ $inspection->remarks ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('inspections.edit', $inspection->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No inspections found for this Jobcard.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
