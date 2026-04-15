@extends('layouts.app')

@section('title', 'Inspections')

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
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('inspections.create') }}" class="float-end btn btn-sm btn-rounded btn-primary"><i class="fas fa-plus"></i> Add Inspection</a>
                            <h4 class="card-title">Inspection List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SR NO</th>
                                            <th>JOBCARD NO</th>
                                            <th>CLIENT</th>
                                            <th>BODY STATUS</th>
                                            <th>DISPLAY</th>
                                            <th>MOTHERBOARD</th>
                                            <th>POWER CARD</th>
                                            <th>SENSOR</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inspections as $index => $inspection)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $inspection->jobcard->jobcard_number }}</td>
                                                <td>{{ $inspection->jobcard->customer_name }}</td>
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
                                                <td style="white-space: nowrap;">
                                                    <div class="form-button-action">
                                                        <a href="{{ route('inspections.show', $inspection->id) }}" class="btn btn-link btn-info" data-bs-toggle="tooltip" title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('inspections.edit', $inspection->id) }}" class="btn btn-link btn-primary" data-bs-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button onclick="delete_inspection({{ $inspection->id }})" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No data available</td>
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
</div>
@endsection

@section('footer-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });

        function delete_inspection(id) {
            var url = "{{ url('inspections') }}/" + id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    response.message ?? 'Inspection deleted successfully',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    response.message ?? 'Delete failed',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Something went wrong!',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
    @endsection
