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
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('jobcards.index') }}">Jobcards</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('jobcards.create') }}" class="float-end btn btn-sm btn-rounded btn-primary"><i
                                    class="fas fa-plus"></i> Add Jobcard</a>
                            <h4 class="card-title">Jobcard List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SR NO</th>
                                            <th>JOBCARD NO</th>
                                            <th>CLIENT</th>
                                            <th>CUSTOMER NAME</th>
                                            <th>TAG NO</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jobcards as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->jobcard_number }}</td>
                                                <td>{{ optional($item->client)->name ?? 'N/A' }}</td>
                                                <td>{{ $item->customer_name }}</td>
                                                <td>{{ $item->tag_no }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $item->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($item->status) }}</span>
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="{{ route('inspections.create', ['jobcard_id' => $item->id]) }}"
                                                            class="btn btn-link btn-success" data-bs-toggle="tooltip"
                                                            title="Add Inspection">
                                                            <i class="fa fa-clipboard-check"></i>
                                                        </a>
                                                        <a href="{{ route('jobcards.show', $item->id) }}"
                                                            class="btn btn-link btn-info" data-bs-toggle="tooltip"
                                                            title="View Details">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('jobcards.edit', $item->id) }}"
                                                            class="btn btn-link btn-primary" data-bs-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button onclick="delete_jobcard({{ $item->id }})"
                                                            class="btn btn-link btn-danger" data-bs-toggle="tooltip"
                                                            title="Delete">
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
@endsection
@section('footer-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#basic-datatables').DataTable({});
        });

        function delete_jobcard(id) {
            var url = "{{ url('jobcards') }}/" + id;

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
                        type: 'POST', // ✅ CHANGE (Laravel friendly)
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE' // ✅ IMPORTANT
                        },

                        success: function (response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    response.message ?? 'Jobcard deleted successfully',
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

                        error: function (xhr) {
                            console.log(xhr.responseText); // debug
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