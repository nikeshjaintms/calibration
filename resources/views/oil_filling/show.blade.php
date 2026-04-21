@extends('layouts.app')

@section('title', 'Oil Filling Details')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Oil Filling Details</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('oil-fillings.index') }}">Oil Filling</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">Details</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Filling Information</h4>
                        <a href="{{ route('oil-fillings.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="text-uppercase text-muted fw-bold">Jobcard Information</h6>
                                <p class="mb-1"><strong>Jobcard Number:</strong> {{ $oil_filling->jobcard->jobcard_number ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Customer Name:</strong> {{ $oil_filling->jobcard->customer_name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Client:</strong> {{ $oil_filling->jobcard->client->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h6 class="text-uppercase text-muted fw-bold">Filling Details</h6>
                                <p class="mb-1"><strong>Filling Date:</strong> {{ \Carbon\Carbon::parse($oil_filling->filling_date)->format('d-M-Y') }}</p>
                                <p class="mb-1"><strong>Oil Type:</strong> {{ $oil_filling->oil_type }}</p>
                                <p class="mb-1"><strong>Quantity:</strong> {{ $oil_filling->quantity }}</p>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <h6 class="text-uppercase text-muted fw-bold">Components Used</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="mb-1"><strong>MOC:</strong> {{ $oil_filling->moc->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1"><strong>FLANGE:</strong> {{ $oil_filling->flange->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1"><strong>CAPILLARY:</strong> {{ $oil_filling->capillary->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="alert alert-info py-2">
                                    <strong>Filled By:</strong> {{ $oil_filling->user->name ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('oil-fillings.edit', $oil_filling->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Record
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
