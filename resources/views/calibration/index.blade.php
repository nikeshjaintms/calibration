@extends('layouts.app')

@section('title', 'Calibrations')

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
                    <a href="#">Calibrations</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">Calibration Records</div>
                        <a href="{{ route('calibrations.create') }}" class="btn btn-primary btn-round">
                            <i class="fa fa-plus"></i> Add Calibration
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SR NO</th>
                                        <th>Date</th>
                                        <th>Jobcard No</th>
                                        <th>Customer</th>
                                        <th>Instrument</th>
                                        <th>Cert No</th>
                                        <th>Result</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calibrations as $calibration)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($calibration->date)->format('d/m/Y') }}</td>
                                        <td>{{ $calibration->jobcard->jobcard_number ?? 'N/A' }}</td>
                                        <td>{{ $calibration->jobcard->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $calibration->instrument }}</td>
                                        <td>{{ $calibration->certificate_number }}</td>
                                        <td>
                                            @if($calibration->result == 'pass')
                                            <span class="badge badge-success">PASS</span>
                                            @else
                                            <span class="badge badge-danger">FAIL</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('jobcards.certificate', $calibration->jobcard_id) }}" class="btn btn-link btn-success" data-bs-toggle="tooltip" title="Print PDF" target="_blank">
                                                    <i class="fa fa-file-pdf"></i>
                                                </a>
                                                <a href="{{ route('calibrations.show', $calibration->id) }}" class="btn btn-link btn-info" data-bs-toggle="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('calibrations.edit', $calibration->id) }}" class="btn btn-link btn-primary" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" onclick="deleteCalibration({{ $calibration->id }})" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
            "bLengthChange": false,
        });
    });

    function deleteCalibration(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('calibrations') }}/" + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'Record has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        })
    }
</script>
@endsection
