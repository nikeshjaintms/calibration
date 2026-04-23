@extends('layouts.app')

@section('title', 'Oil Filling List')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Oil Filling</h3>
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
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('oil-fillings.create') }}" class="float-end btn btn-sm btn-rounded btn-primary">
                            <i class="fas fa-plus"></i> Add Oil Filling
                        </a>
                        <h4 class="card-title">Oil Filling List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SR NO</th>
                                        <th>JOBCARD NO</th>
                                        <th>OIL TYPE</th>
                                        <th>QUANTITY</th>
                                        <th>DATE</th>
                                        <th>USER</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($oil_fillings as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->jobcard->jobcard_number ?? 'N/A' }}</td>
                                            <td>{{ $item->oil_type }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->filling_date)->format('d-M-Y') }}</td>
                                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                                            <td style="white-space: nowrap;">
                                                <div class="form-button-action">
                                                    <a href="{{ route('oil-fillings.show', $item->id) }}" class="btn btn-link btn-info" data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('oil-fillings.edit', $item->id) }}" class="btn btn-link btn-primary" data-bs-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('oil-fillings.pdf', $item->id) }}" class="btn btn-link btn-success" data-bs-toggle="tooltip" title="Download PDF" target="_blank">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                    <button onclick="delete_oil_filling({{ $item->id }})" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No data available</td>
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

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({});
    });

    function delete_oil_filling(id) {
        var url = "{{ url('oil-fillings') }}/" + id;

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
                                response.message ?? 'Record deleted successfully',
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
@endsection
